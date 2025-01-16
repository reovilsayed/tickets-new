<?php

namespace App\Http\Controllers;

use Sohoj;
use Illuminate\Support\Str;
use App\Http\Resources\EventCollection;
use App\Http\Resources\ProductCollection;
use App\Mail\TicketDownload;
use App\Models\Event;
use App\Models\Extra;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TOCOnlineService;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use Vemcogroup\SmsApi\SmsApi;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = $request->get('query');
        $event_id = $request->get('event_id');
        $event_date = $request->get('event_date');

        $products = Product::with('event')
            ->where('quantity', '>', 0)
            ->where('name', 'like', "%{$query}%")
            ->where('status', 1)
            ->whereHas('poses', function ($q) {
                $q->where('pos_id', auth()->user()->pos_id); // Filtering based on user's pos_id
            })
            ->whereIn('type', ['pos', 'both'])
            ->where('invite_only', 0);

        if ($event_id) {
            $products->where('event_id', $event_id);
        }
        // this may be wrong --- for future ref
        if (!empty($event_date)) {
            $products->whereDate('start_date', '<=', $event_date)
                ->whereDate('end_date', '>=', $event_date);
        }
        $products = $products->paginate($perPage);
        return new ProductCollection($products);
    }

    public function getTicket(Request $request)
    {
        $ticket = Ticket::where('ticket', $request->ticket)->with(['event', 'product'])->first();
        if (!$ticket)
            return response()->json(['message' => 'No ticket was found'], status: 404);
        $ticketData = [
            "id" => $ticket["id"],
            "owner" => $ticket["owner"],
            "event_id" => $ticket["event_id"],
            "event_name" => $ticket->event["name"],
            "even" => $ticket["event"],
            "product_id" => $ticket["product_id"],
            "product_name" => $ticket->product["name"],
            "order_id" => $ticket?->order,
            "user_id" => $ticket["user_id"],
            "ticket" => $ticket["ticket"],
            "status" => $ticket["status"],
            "dates" => $ticket["dates"],
            "price" => $ticket["price"],
            "created_at" => $ticket["created_at"],
            "updated_at" => $ticket["updated_at"],
            "type" => $ticket["type"],
            "logs" => $ticket["logs"],
            "active" => $ticket["active"],
            "check_in_zone" => $ticket["check_in_zone"],
            "check_out_zone" => $ticket["check_out_zone"],
            "hasExtras" => $ticket["hasExtras"],
            "extras" => [],
        ];
        $extras = $ticket->extras;
        foreach ($extras as $extra) {
            $ticketData['extras'][] = ['id' => $extra['id'], 'name' => Extra::find($extra['id'])->display_name, 'qty' => $extra['qty'], 'used' => @$extra['used'] ?? 0, 'price' => Extra::find($extra['id'])->price];
        }

        return response()->json($ticketData);
    }

    public function ticketExtras(Request $request)
    {
        $validatedData = $request->validate([
            'extras' => 'required|array',
            'extras.*' => 'integer|exists:extras,id',
        ]);

        $extrasList = $validatedData['extras'];

        $extras = Extra::whereIn('id', $extrasList)->whereHas('poses', function ($q) {
            $q->where('pos_id', auth()->user()->pos_id); // Filtering based on user's pos_id
        })->get();

        return response()->json($extras);
    }

    public function events(Request $request)
    {
        $events = Event::where('status', 1)->get();

        return new EventCollection($events);
    }

    public function extras(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = $request->get('query');
        $event_id = $request->get('event_id');

        $extras = Extra::with('event')->whereHas('poses', function ($q) {
            $q->where('pos_id', auth()->user()->pos_id); // Filtering based on user's pos_id
        })->where('name', 'like', "%{$query}%");

        if ($event_id) {
            $extras->where('event_id', $event_id);
        }

        $extras = $extras->paginate($perPage);

        return response()->json($extras);
    }

    public function eventExtras(Request $request, $event)
    {
        $perPage = $request->get('per_page', 10);

        $query = $request->get('query');

        $extras = Extra::with('event')->where('name', 'like', "%{$query}%")->where('event_id', $event)->paginate($perPage);

        return response()->json($extras);
    }

    protected function getUser($billing)
    {
        $email = $billing['email'] ?? null;
        $phone = $billing['phone'] ?? null;

        if ($phone) {
            // Attempt to find user by phone
            $user = User::where('contact_number', $phone)->orWhere('email', $email)->first();

            // If no user is found by phone, create with a fake email
            if (!$user) {
                $user = User::create([
                    'name' => @$billing['name'],
                    'email' => $email ?? 'fake' . uniqid() . '@mail.com',
                    'contact_number' => $phone,
                    'email_verified_at' => now(),
                    'role_id' => 2,
                    'password' => Hash::make('password2176565'),
                    'country' => 'PT',
                    'vatNumber' => $billing['vatNumber'] ?? null,

                ]);
            }
        } elseif ($email) {
            // Attempt to find user by email
            $query = User::where('email', $email);

            if ($phone) {
                $query->orWhere('contact_number', $phone);
            }

            $user = $query->first();

            // If no user is found by email, create with email provided
            if (!$user) {
                $user = User::create([
                    'name' => @$billing['name'],
                    'email' => $email,
                    'contact_number' => $phone,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password2176565'),
                    'country' => 'PT',
                    'role_id' => 2,
                    'vatNumber' => $billing['vatNumber'] ?? null,

                ]);
            }
        } else {
            // Handle case when neither phone nor email is provided
            $user = User::create([
                'name' => @$billing['name'],
                'email' => 'fake' . uniqid() . '@mail.com',
                'contact_number' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password2176565'),
                'country' => 'PT',
                'role_id' => 2,
                'vatNumber' => $billing['vatNumber'] ?? null,

            ]);
        }

        return $user;
    }

    public function createOrder(Request $request)
    {
        // Collect initial order data
        // try {
        DB::beginTransaction();
        $extraProducts = $request->get('extras') ?? [];
        $tickets = $request->get('tickets') ?? [];

        if (count($extraProducts) <= 0 && count($tickets) <= 0) throw new Exception('No products in cart');
        foreach ($tickets as $item) {
            $product = Product::findOrFail($item['id']);
            if ($product->quantity < $item['quantity']) {
                throw new Exception($item['name'] . ' is not available for this quantity');
            }
        }
        $orderData = [
            'billing' => request()->get('biling'),
            'user_id' => $this->getUser(request()->get('biling'))->id,
            'subtotal' => $request->get('subTotal'),
            'discount' => 0,
            'total' => $request->get('total'),
            'event_id' => $request->get('event_id'),
            'payment_method' => $request->get('paymentMethod') ?? 'Pos',
            'transaction_id' => Str::uuid(),
            'security_key' => Str::uuid(),
            'send_message' => $request->get('sendToPhone') ? true : false,
            'send_email' => $request->get('sendToMail') ? true : false,
            'pos_id' => auth()->id()
        ];



        $order = Order::create($orderData);


        // Calculate total quantity of extras and tickets
        $totalItems = 0;


        foreach ($extraProducts as $extra) {
            $quantity = @$extra['quantity'] ?? @$extra['newQty'] ?? 0;
            $totalItems +=  $quantity;
        }
        foreach ($tickets as $ticket) {
            $totalItems += $ticket['quantity'];
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

        // Handle ticket creation and price adjustment
        $hollowTickets = [];
        $physicalQr = $request->get('physicalQr');

        foreach ($tickets as $item) {
            $product = Product::findOrFail($item['id']);
            $product->quantity -= $item['quantity'];
            $product->save();

            for ($i = 0; $i < $item['quantity']; $i++) {
                $data = [
                    'owner' => [
                        'name' => request()->get('biling')['name'] ?? '',
                        'email' => request()->get('biling')['email'] ?? '',
                        'vatNumber' => request()->get('biling')['vatNumber'] ?? '',
                        'address' => request()->get('biling')['address'] ?? '',
                    ],
                    'event_id' => $product->event->id,
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'user_id' => $orderData['user_id'],
                    'pos_id' => auth()->id(),
                    'ticket' => !$physicalQr ? uniqid() : null,
                    'price' =>  $product->price,
                    'dates' => $product->dates,
                    'type' => 'pos'
                ];

                $extras = $item['extras'] ?? [];
                if (count($extras)) {
                    $data['hasExtras'] = true;
                    foreach ($extras as $extra) {
                        $newQuantity = $extra['newQuantity'] ?? 0;
                        $quantity = $extra['quantity'] ?? 0;
                        $price = $extra['price'] ?? 0;
                        if ($newQuantity > $quantity) {
                            $data['price'] += (($newQuantity - $quantity) * $price);
                        }
                    }
                    $data['extras'] = collect($extras)->map(fn($extra) => [
                        'id' => $extra['id'],
                        'name' => Extra::find($extra['id'])->display_name,
                        'qty' => $extra['newQuantity'] ?? $extra['quantity'],
                        'price' => $extra['price'],
                        'used' => $request->withdraw ?  $extra['newQuantity'] ?? $extra['quantity'] : 0
                    ])->toArray();
                }
                $hollowTickets[] = $order->tickets()->create($data);
            }
        }

        // Handle invoice printing or emailing
        $printInvoice = $request->get('printInvoice');
        $sendInvoiceToMail = $request->get('sendInvoiceToMail');
        $sendTicketToMail = $request->get('sendToMail') ?? $request->billing->sendToMail;
        // if(env('APP_ENV') != 'local'){



        $phone = isset($orderData['billing']['phone']) ? $orderData['billing']['phone'] : '';

        // Return the order with tickets

        DB::commit();
        $order->update([
            'status' => 1,
            'payment_status' => 1
        ]);

        try {
            $toco = new TOCOnlineService;
            $response = $toco->createCommercialSalesDocument($order);

            $order->invoice_id = $response['id'];
            $order->invoice_url = $response['public_link'];
            $order->invoice_body = json_encode($response);

            if ($sendInvoiceToMail || $sendTicketToMail) {
                $toco->sendEmailDocument($order, $response['id']);
            }
        } catch (Exception | Error $e) {
            Log::info($e->getMessage());
        }

        $order->save();

        $order['tickets'] = $hollowTickets;

        if ($printInvoice == false) {
            $order->invoice_url = null;

            // Add invoice creation logic if needed
        }


        $data = [
            'id' => $order->id,
            'tickets' => $hollowTickets,
            'invoice_url' => $order->invoice_url,
        ];

        return response()->json($data, 200);
        // } catch (Exception | Error $e) {
        //     DB::rollBack();
        //     return response()->json(['message' => $e->getMessage(), 'status' => false], 400);
        // }
    }


    public function updateTicket(Request $request)
    {

        $requestTicket = $request->ticket;
        $ticket = Ticket::findOrFail($requestTicket['id']);
        $ticket->extras = collect($requestTicket['extras'])->map(function ($extra) use ($request) {
            $data = ['id' => $extra['id'], 'name' => Extra::find($extra['id'])->display_name, 'qty' => @$extra['newQty'] ?? $extra['qty'], 'price' => $extra['price'], 'used' => @$extra['used'] ?? 0];
            if ($request->can_withdraw && @$extra['newQty']) {
                $data['used'] =  @$extra['newQty'];
            }
            return $data;
        })->toArray();
        $ticket->save();

        // $totalPrice = 0;
        // $extras = [];
        // foreach ($requestTicket['extras'] as $extra) {
        //     $quantity = (int)(($extra['newQty'] ?? $extra['qty']) - $extra['qty']);
        //     if ($quantity > 0) {
        //         $price =  $quantity * $extra['price'];
        //         $totalPrice += $price;
        //         $data = ['id' => $extra['id'], 'name' => Extra::find($extra['id'])->display_name, 'qty' => $quantity,  'price' => $quantity * $extra['price']];

        //         $extras[] = $data;
        //     }
        // }

        // $orderData = [
        //     'user_id' => $ticket['user_id'],
        //     'subtotal' => $totalPrice,
        //     'discount' => 0,
        //     'total' => $totalPrice,
        //     'status' => 1,
        //     'payment_status' => 1,
        //     'payment_method' => 'pos',
        //     'transaction_id' => Str::uuid(),
        //     'security_key' => Str::uuid(),
        //     'extras' => json_encode($extras)
        // ];
        // $order = Order::create($orderData);
        return response()->json(['ticket' => $ticket]);
    }

    public function updateTicketCode(Request $request)
    {
        $requestTicket = $request->ticket;
        $ticket = Ticket::where('id', $requestTicket)->where('ticket', null)->first();
        if (!$ticket) {
            return response()->json(['message' => 'Ticket already scanned.']);
        }
        $ticket->ticket = $request->code;
        $ticket = $ticket->save();
        return response()->json(['ticket' => $ticket]);
    }

    public function activateTicket(Request $request)
    {
        $requestTicket = $request->ticket;
        $ticket = Ticket::findOrFail($requestTicket);
        if ($ticket->active == 1) return response()->json(['ticket' => $ticket]);
        $ticket->active = 1;
        $ticket->save();
        return response()->json(['ticket' => $ticket]);
    }

    public function toggleTicketActive(Request $request)
    {
        $requestTicket = $request->ticket;
        $ticket = Ticket::findOrFail($requestTicket);
        if ($ticket->active == 1) {
            $ticket->active = 0;
        } else {
            $ticket->active = 1;
        }
        $ticket->save();
        return response()->json(['ticket' => $ticket]);
    }

    public function paidTicketStatusUpdate(Request $request)
    {
        $requestTicket = $request->ticket;
        $ticket = Ticket::findOrFail($requestTicket);

        $orderData = [
            'billing' => request()->get('biling'),
            'user_id' => $ticket->user_id,
            'subtotal' => $ticket->price,
            'discount' => 0,
            'total' => $ticket->price,
            'event_id' => $ticket->event_id,
            'payment_method' => $request->get('paymentMethod') ?? 'Pos',
            'transaction_id' => Str::uuid(),
            'security_key' => Str::uuid(),
            'send_message' => $request->get('sendToPhone') ? true : false,
            'send_email' => $request->get('sendToMail') ? true : false,
            'pos_id' => auth()->id()
        ];
        $order = Order::create($orderData);

        $ticket->active = 1;
        $ticket->order_id = $order->id;
        
        $ticket->save();
        try {
            $toco = new TOCOnlineService;
            $response = $toco->createCommercialSalesDocument($order);

            $order->invoice_id = $response['id'];
            $order->invoice_url = $response['public_link'];
            $order->invoice_body = json_encode($response);
            $sendInvoiceToMail = $request->get('sendInvoiceToMail');
            if ($sendInvoiceToMail) {
                $toco->sendEmailDocument($order, $response['id']);
            }
            $order->save();
        } catch (Exception | Error $e) {
            Log::info($e->getMessage());
        }
        return response()->json(['ticket' => $ticket]);
    }
}
