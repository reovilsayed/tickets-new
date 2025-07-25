<?php

namespace App\Http\Controllers\Api\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Extra;
use App\Models\Order;
use App\Models\User;
use App\Services\TOCOnlineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class CreateOrderController extends Controller
{
    private const DEFAULT_USER_ROLE = 2;
    private const DEFAULT_COUNTRY = 'PT';
    private const DEFAULT_PASSWORD = 'password2176565';

    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'extras' => 'required|array|min:1',
                'billing' => 'required|array',
                'billing.name' => 'required|string|min:2',
                'billing.email' => 'nullable|email',
                'billing.phone' => 'nullable|string',
                'billing.vatNumber' => 'nullable|string',
                'user_id' => 'nullable|exists:users,id',
                'event_id' => 'required|exists:events,id',
                'subtotal' => 'required|numeric|min:0',
                'total' => 'required|numeric|min:0',
                'payment_method' => 'required|string|in:qr,card,cash',
                'send_message' => 'nullable|boolean',
                'send_email' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = (object) $validator->validated();
            $extras = $data->extras ?? [];

            if (empty($extras)) {
                throw new \Exception('No products in cart');
            }

            DB::beginTransaction();

            $order = $this->createOrder($data);
            $this->attachExtras($order, $extras);
            $this->takePayment($order);



            DB::commit();

            if (config('app.env') !== 'local') {
                $this->handleTOCOnlineIntegration($order);
            }

            $order->load('posUser', 'user');

            return response()->json([
                'status' => true,
                'message' => 'Order created successfully',
                'order' => [
                    'id' => $order->id,
                    'invoice_url' => $order->invoice_url,
                    'data' => OrderResource::make($order)
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function takePayment(Order $order): void
    {
        if ($order->payment_method === 'qr' && $order->user_id) {
            $user = User::findOrFail($order->user_id);
            $user->spend($order->total, 'Order number - ' . $order->id);
        }

        $order->update([
            'status' => Order::STATUS_PAID,
            'payment_status' => Order::PAYMENT_STATUS_PAID
        ]);
    }

    protected function attachExtras(Order $order, array $extras): void
    {

        $orderExtras = [];

        foreach ($extras as $extra) {
            $quantity = $extra['quantity'] ?? $extra['newQty'] ?? 0;

            if (isset($extra['id'])) {
                $extraModel = Extra::findOrFail($extra['id']);
                $price = max(0, $extra['price'] ?? 0);

                $orderExtras[] = [
                    'id' => $extra['id'],
                    'name' => $extraModel->display_name,
                    'qty' => $quantity,
                    'price' => $price,
                ];
            }
        }

        $order->update([
            'extras' => json_encode($orderExtras),
        ]);
    }

    protected function createOrder(object $data): Order
    {
        $user = null;
        if ($data->user_id) {
            $user = User::find($data->user_id);
        }

        if (!$user) {
            $user = $this->getUser($data->billing);
        }

        return Order::create([
            'billing' => $data->billing,
            'user_id' => $user->id,
            'event_id' => $data->event_id,
            'subtotal' => $data->subtotal,
            'discount' => 0,
            'total' => $data->total,
            'payment_method' => $data->payment_method ?? 'App',
            'transaction_id' => Str::uuid(),
            'security_key' => Str::uuid(),
            'send_message' => (bool) ($data->send_message ?? false),
            'send_email' => (bool) ($data->send_email ?? false),
            'pos_id' => auth()->id()
        ]);
    }

    protected function getUser(array $billing): User
    {
        $email = trim($billing['email'] ?? '');
        $phone = trim($billing['phone'] ?? '');

        $user = null;


        $query = User::query();

        if (!empty($phone)) {
            $user = $query->where('contact_number', $phone)->first();
        }

        if (!$user && !empty($email)) {
            $user = $query->where('email', $email)->first();
        }



        if (!$user) {
            $user = User::create([
                'name' => $billing['name'] ?? 'Unknown User',
                'email' => !empty($email) ? $email : $this->generateUniqueEmail($billing['name'] ?? 'user'),
                'contact_number' => !empty($phone) ? $phone : null,
                'email_verified_at' => now(),
                'role_id' => self::DEFAULT_USER_ROLE,
                'password' => Hash::make(self::DEFAULT_PASSWORD),
                'country' => self::DEFAULT_COUNTRY,
                'vatNumber' => $billing['vatNumber'] ?? null,
            ]);
        }

        return $user;
    }

    protected function handleTOCOnlineIntegration(Order $order): void
    {
        $toco = new TOCOnlineService;
        $response = $toco->createCommercialSalesDocument($order);

        if (is_string($response)) {
            $order->update([ 
                'invoice_body' => json_encode($response)
            ]);
            return;
        }

        $order->update([
            'invoice_id' => $response['id'],
            'invoice_url' => $response['public_link'],
            'invoice_body' => json_encode($response)
        ]);

        if ($order->send_email) {
            $toco->sendEmailDocument($order, $response['id']);
        }
    }

    private function generateUniqueEmail(string $name): string
    {
        return strtolower(Str::slug($name)) . '+' . uniqid() . '@mail.com';
    }
}
