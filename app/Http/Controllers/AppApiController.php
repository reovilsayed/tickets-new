<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventCollection;
use App\Http\Resources\ExtraResoure;
use App\Models\Event;
use App\Models\Extra;
use App\Models\ExtraCategory;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Zone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\WithdrawLog;
use App\Services\TOCOnlineService;
use Error;

class AppApiController extends Controller
{
    function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                $token = $user->createToken('authToken')->plainTextToken;
                $data = $user;
                $data['pos'] = $user->pos;
                return response()->json(['token' => $token, 'user' => $data], 200);
            } else {
                return response()->json(['error' => 'Invalid password'], 401);
            }
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    function user(Request $request)
    {
        $user = auth('sanctum')->user();
        $user->load('pos');
        $user->token = $user->currentAccessToken()->token;
        return $user;
    }

    function checkin(Request $request)
    {
        $ticket = $request->ticket;
        $zone = Zone::where("security_key", $request->zone_id)->first();
        $ticket = Ticket::where('ticket', $ticket)->with('product')->firstOrFail();
        if ($ticket->active == 0) {
            return response()->json(['error' => __('words.ticket_not_active')], 500);
        }
        // check if the ticket is valid for the current date
        if (!in_array(now()->format('Y-m-d'), $ticket->dates)) {
            return response()->json(['error' => __('words.to_early_to_scan')], 500);
        }

        // check if the ticket is valid for this zone
        if ($ticket->product->zones->doesntContain($zone)) {
            return response()->json(['error' => __('words.invalid_zone_error')], 500);
        }

        $isCheckedIn = $ticket->scanedBy()
            ->where('action', 'Checked in')
            ->where('zone_id', $zone->id)
            ->exists();

        if ($ticket->product->one_time && $isCheckedIn) {
            return response()->json(['error' => __('words.one_time_usage')], 500);
        }

        $lastScan = $ticket->scanedBy()
            ->whereIn('action', ['Checked in', 'Checked Out'])
            ->where('zone_id', $zone->id)
            ->whereDate('ticket_user.created_at', today())
            ->orderByPivot('created_at', 'desc')
            ->first();

        $isCheckedIn = Str::of($lastScan?->pivot?->action)->lower()->exactly('checked in');

        if ($isCheckedIn) {
            return response()->json(['error' => __('words.ticket_already_scanned_error')], 500);
        }

        $ticket->update([
            'logs' => [
                ...$ticket->logs,
                [
                    'time' => now()->format('Y-m-d H:i:s'),
                    'action' => 'Checked in',
                    'zone' => $zone->name
                ]
            ],
            'check_in_zone' => $zone->id,
            'status' => 1
        ]);

        $ticket->scanedBy()
            ->attach(
                auth()->user(),
                ['action' => 'Checked in', 'zone_id' => $zone->id]
            );

        return response()->json(['message' => __('words.ticket_checked_in'), 'data' => $ticket], 200);
    }


    public function checkOut(Request $request)
    {
        $zone = Zone::where("security_key", $request->zone_id)->first();
        $ticket = Ticket::with('product')->where('ticket', $request->ticket)
            ->firstOrFail();

        if ($zone == null) {
            return response()->json(['error' => __('words.invalid_zone_error')], 500);
        }

        $lastScan = $ticket->scanedBy()
            ->whereIn('action', ['Checked in', 'Checked Out'])
            ->where('zone_id', $zone->id)
            ->whereDate('ticket_user.created_at', today())
            ->orderByPivot('created_at', 'desc')
            ->first();

        $isCheckedOut = Str::of($lastScan?->pivot?->action)->lower()->exactly('checked out');

        if ($isCheckedOut || is_null($lastScan) || !$ticket->product->check_out || $ticket->product->one_time) {
            return response()->json(['error' => __('words.check_out_not_available')], 500);
        }

        $ticket->update([
            'logs' => [
                ...$ticket->logs,
                [
                    'time' => now()->format('Y-m-d H:i:s'),
                    'action' => 'Checked Out',
                    'zone' => $zone->name
                ]
            ],
            'check_out_zone' => $zone->id
        ]);

        $ticket->scanedBy()
            ->attach(
                auth()->user(),
                ['action' => 'Checked Out', 'zone_id' => $zone->id]
            );
        return response()->json(['message' => __('words.ticket_checked_out')], 200);
    }

    public function getExtras(Request $request)
    {
        $ticket = Ticket::where('ticket', $request->ticket)->where('active', 1)->first();
        $posId = auth()->user()->pos_id ?? null;
        if ($ticket) {
            $extras = [];

            $data = collect($ticket->extras)->filter(function ($extra) use ($posId) {
                try {
                    $extra = Extra::find($extra['id']);
                    return $posId !== null ? $extra->poses->pluck('id')->contains($posId) : $extra;
                } catch (Exception | Error $e) {
                    return null;
                }
            });
            foreach ($data as $extra) {
                array_push($extras, $extra);
            }
            $data = ['status' => 'success', 'extras' => $extras, 'ticket' => $ticket];
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Invalid ticket error']);
        }
    }

    public function getZoneType(Request $request)
    {
        $zone_id = $request->zone;
        $zone = Zone::where("security_key", $zone_id)->first();
        if ($zone == null) {
            return response()->json(['error' => __('words.invalid_zone_error')], 500);
        }
        $user = auth('sanctum')->user();
        // if (!$user->zones->contains($zone)) {
        //     return response()->json(['error' => "You are not authorised to access that zone"], 401);
        // }

        return response()->json(['food_zone' => $zone->type == 1, 'zone' => $zone]);
    }

    public function withdrawExtra(Request $request)
    {
        $request->validate([
            'ticket' => 'required',
            'withdraw' => 'required',
            // 'zone' => 'required',
        ]);

        // if (session()->get('enter-extra-zone')['id'] != $request->session) {
        //     throw new Exception(__('Unauthorized access'));
        // }

        $ticket = Ticket::where('ticket', $request->ticket)->first();
        $extras = $ticket->extras;
        $log = [];
        // $zone = Zone::where("security_key", $request->zone)->first();

        if ($ticket->active == 0) {
            return response()->json(['error' => __('words.ticket_not_active')]);
        }
        if (!in_array(now()->format('Y-m-d'), $ticket->dates)) {
            return response()->json(['error' => __('words.to_early_to_scan')], 500);
        }

        /* if ($zone == null) {
            return response()->json(['error' => __('words.invalid_zone_error')], 500);
        }
        $log = ['time' => now()->format('Y-m-d H:i:s'), 'action' => '', 'zone' => $zone->name]; */

        // Normalize the extras array to ensure consistent structure
        $log = ['time' => now()->format('Y-m-d H:i:s'), 'action' => '', 'zone' => 'Pos user ' . auth()->user()->name];
        $normalizedExtras = [];
        foreach ($extras as $key => $extra) {
            if (is_array($extra) && isset($extra['id'])) {
                $normalizedExtras[$extra['id']] = $extra;
            } elseif (is_object($extra) && isset($extra->id)) {
                $normalizedExtras[$extra->id] = (array) $extra;
            }
        }

        foreach ($request->withdraw as $key => $qty) {
            if ($qty && isset($normalizedExtras[$key])) {

                $normalizedExtras[$key]['used'] += $qty;

                if ($normalizedExtras[$key]['used'] > $normalizedExtras[$key]['qty']) {
                    return $normalizedExtras[$key]['used'] = $normalizedExtras[$key]['qty'];
                }

                $log['action'] = 'Withdrawn ' . $qty . ' quantity of ' . $normalizedExtras[$key]['name'];
                WithdrawLog::create([
                    'event_id'   => $ticket->event_id,
                    'ticket_id'  => $ticket->id,
                    'zone_id'    => null,
                    'user_id'    => auth()->id(),
                    'product_id' => $normalizedExtras[$key]['id'] ?? null,
                    'name'       => $normalizedExtras[$key]['name'],
                    'quantity'   => $qty,
                    'used'       => $normalizedExtras[$key]['used'],
                    'amount'      => $normalizedExtras[$key]['amount'] ?? 0,
                ]);
            }
        }

        $data = $ticket->logs;
        array_push($data, $log);
        $ticket->extras = $normalizedExtras;
        $ticket->logs = $data;
        $ticket->save();

        return response()->json(['message' => __('words.extra_product_withdraw_success_message')]);
    }

    public function getAllExtras(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = $request->get('query');
        $event_id = $request->get('event_id');
        $category_id = $request->get('category_id');

        $extras = Extra::with('event')->whereHas('poses', function ($q) {
            $q->where('pos_id', auth()->user()->pos_id); // Filtering based on user's pos id
        })->when($request->filled('query'), function ($q) use ($query) {
            $q->where('name', 'like', "%{$query}%");
        });

        if ($event_id) {
            $extras->where('event_id', $event_id);
        }

        if ($category_id) {
            $extras->where('extra_category_id', $category_id);
        }

        $extras = $extras->paginate(50);

        return ExtraResoure::collection($extras);
    }

    public function getExtraCategories(Request $request)
    {
        $eventId = $request->event;
        $posId = auth()->user()->pos_id;

        $categories = ExtraCategory::orderBy('order', 'asc')
            ->whereHas('extras', function ($query) use ($eventId, $posId) {
                if ($eventId) {
                    $query->where('event_id', $eventId);
                }
                $query->whereHas('poses', function ($q) use ($posId) {
                    $q->where('pos_id', $posId);
                });
            });

        if ($eventId) {
            $categories = $categories->where('event_id', $eventId);
        }

        $categories = $categories->get();

        return response()->json(['data' => $categories]);
    }

    public function getOrders()
    {
        $orders = auth()->user()->orders;
        return response()->json($orders);
    }

    protected function getUser($billing)
    {
        $email = isset($billing['email']) ? $billing['email'] : null;
        $phone = isset($billing['phone']) ? $billing['phone'] : null;

        $user = null;
        $user_by_phone = null;
        $user_by_email = null;
        if ($phone) {
            $user_by_phone = User::where('contact_number', $phone)->first();
        }
        if ($email) {
            $user_by_email = User::where('email', $email)->first();
        }

        if ($user_by_phone) {
            $user = $user_by_phone;
        } elseif ($user_by_email) {
            $user = $user_by_email;
        }

        if (!$user) {
            $user = User::create([
                'name' => $billing['name'] ?? 'unkown user',
                'email' => $email ?? strtolower(Str::slug($billing['name'] ?? 'user')) . '+' . uniqid() . '@mail.com',
                'contact_number' => $phone,
                'email_verified_at' => now(),
                'role_id' => 2,
                'password' => Hash::make('password2176565'),
                'country' => 'PT',
                'vatNumber' => $billing['vatNumber'] ?? null,
            ]);
        }

        return $user;
    }

    public function createOrder(Request $request)
    {
        // Collect initial order data
        try {
            DB::beginTransaction();
            $extraProducts = $request->get('extras') ?? [];

            if (count($extraProducts) <= 0) throw new Exception('No products in cart');

            $orderData = [
                'billing' => request()->get('billing'),
                'user_id' => $this->getUser(request()->get('billing'))->id,
                'subtotal' => $request->get('sub_total'),
                'discount' => 0,
                'total' => $request->get('total'),
                // 'event_id' => $request->get('event_id'),
                'payment_method' => $request->get('payment_method') ?? 'App',
                'transaction_id' => Str::uuid(),
                'security_key' => Str::uuid(),
                'send_message' => $request->get('send_message') ? true : false,
                'send_email' => $request->get('send_mail') ? true : false,
                'pos_id' => auth()->id()
            ];

            $order = Order::create($orderData);

            if ($request->get('payment_method') == 'Wallet' && $request->has('user_id')) {
                $user = User::find($request->user_id);
                $user->spend($request->get('total'), 'Order number - ' . $order->id);
            }


            // Calculate total quantity of extras and tickets
            $totalItems = 0;


            foreach ($extraProducts as $extra) {
                $quantity = @$extra['quantity'] ?? @$extra['newQty'] ?? 0;
                $totalItems +=  $quantity;
            }

            // Adjust extra product prices
            if (count($extraProducts)) {
                $orderExtras = collect($extraProducts)->map(function ($extra) {
                    if (@$extra['id']) {


                        if (@$extra['price']) {
                            $extra['price'];
                        }
                        return [
                            'id' => $extra['id'],
                            'name' => Extra::find($extra['id'])->display_name,
                            'qty' => @$extra['quantity'] ?? 0,
                            'price' => max(0, @$extra['price'] ?? 0), // Ensure price doesn't go below zero
                        ];
                    }
                })->toArray();
                $order['extras'] = json_encode($orderExtras);
            }

            // Handle invoice printing or emailing
            // $printInvoice = $request->get('printInvoice');
            $sendInvoiceToMail = $request->get('send_mail');
            // if(env('APP_ENV') != 'local'){



            $phone = isset($orderData['billing']['phone']) ? $orderData['billing']['phone'] : '';

            // Return the order with tickets

            DB::commit();
            $order->update([
                'status' => 1,
                'payment_status' => 1
            ]);

            /* try {
                $toco = new TOCOnlineService;
                $response = $toco->createCommercialSalesDocument($order);

                $order->invoice_id = $response['id'];
                $order->invoice_url = $response['public_link'];
                $order->invoice_body = json_encode($response);

                if ($sendInvoiceToMail) {
                    $toco->sendEmailDocument($order, $response['id']);
                }
            } catch (Exception | Error $e) {
                Log::info($e->getMessage());
                DB::rollBack();
            } */

            $order->save();

            /* if ($printInvoice == false) {
            $order->invoice_url = null;

            // Add invoice creation logic if needed
        } */


            $data = [
                'id' => $order->id,
                // 'tickets' => $hollowTickets,
                'invoice_url' => $order->invoice_url,
            ];

            return response()->json($data, 200);
        } catch (Exception | Error $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage(), 'status' => false], 400);
        }
    }

    function getMyWallet()
    {
        $transactions = Transaction::where('agent_id', auth('sanctum')->id())->latest()->paginate(20);
        $todayDeposit = Transaction::where('agent_id', auth('sanctum')->id())->where('description', 'Deposit')
            ->whereDate('created_at', today())->sum('amount');
        $todayRefund = Transaction::where('agent_id', auth('sanctum')->id())->where('description', 'Refund')
            ->whereDate('created_at', today())->sum('amount');
        return response()->json(['transactions' => $transactions, 'deposit' => (int)($todayDeposit), 'refund' => (int)($todayRefund)]);
    }

    function getWalletCustomer()
    {
        $customer = null;
        if (request()->filled('user')) {
            $customer = User::where(function ($query) {
                $query->where('email', request()->user)->orWhere('contact_number', request()->user);
            })->where('role_id', 2)->first();
        }
        if (request()->filled('qr')) {
            $customer = User::where('uniqid', request()->qr)->where('role_id', 2)->first();
        }
        $transactions = [];
        if ($customer) {
            $transactions = $customer->transactions;
        }
        return response()->json(['customer' => $customer, 'transactions' => $transactions]);
    }

    public function withdrawRefund(Request $request)
    {
        try {
            $request->validate([
                'amount' => 'required',
                'user' => 'required',
                'type' => 'required'
            ]);

            $user = User::find($request->user);

            if ($request->type == 'refund') {
                $user->refund($request->amount);
            } else {
                $user->deposit($request->amount);
            }

            return response()->json(['user' => $user]);
        } catch (Exception | Error $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false], 400);
        }
    }

    public function getUserFromQr(Request $request)
    {
        $user = null;
        $ticket = Ticket::where('ticket', $request->code)->first();
        if ($ticket) {
            $user = User::find($ticket->user_id);
        } else {
            $user = User::where('uniqid', $request->code)->first();
        }

        return response()->json(['user' => $user]);
    }

    public function events(Request $request)
    {
        $events = Event::where('status', 1)->where('in_pos', 1)->get();

        return new EventCollection($events);
    }

    public function createQrUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'nullable|unique:users,email',
            'contact_number' => 'nullable|unique:users,contact_number',
            'vatNumber' => 'nullable|unique:users,vatNumber',
            'code' => 'required|unique:users,uniqid'
        ]);
        if (User::where('uniqid', $request['code'])->exists()) {
            return response()->json(['error' => 'QR code is already associated with another user'], 409);
        }
        $array = [
            'name' => $request['name'],
            'email' => $request['email'] ?? strtolower(Str::slug($request['name'])) . '+' . uniqid() . '@events.essenciacompany.com',
            'contact_number' => $request['contact_number'],
            'vatNumber' => $request['vatNumber'],
            'role_id' => 2,
            'uniqid' => $request['code'],
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        $user = DB::table('users')->insert($array);
        if ($user) {
            $user = User::where('uniqid', $request['code'])->first();
        }
        return response()->json(['user' => $user]);
    }
}
