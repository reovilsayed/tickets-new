<?php

namespace App\Http\Controllers;

use App\Exports\TicketExport;
use App\Mail\InviteDownload;
use App\Mail\TicketDownload;
use App\Models\Coupon;
use App\Models\Event;
use App\Models\Extra;
use App\Models\Invite;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TOCOnlineService;
use Error;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminCustomController extends Controller
{
    public function duplicateProduct(Product $product)
    {
        $newTicket = $product->replicate();
        $newTicket->save();
        return redirect()->back();
    }

    public function inviteAddProduct(Invite $invite)
    {
        $products = $invite->event->products()->where('invite_only', 1)->get();
        return view('vendor.voyager.invite.add', compact('products', 'invite'));
    }

    public function inviteAddProductStore(Invite $invite, Request $request)
    {

        $data = [];
        try {
            foreach ($request->product as $key => $product) {
                if (isset($product['checked'])) {
                    $data[$key] = ['quantity' => $product['qty']];
                }
            }

            $invite->attachProducts($data);

            return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Product attached on invite']);
        } catch (Exception | Error $e) {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function productAddExtras(Product $product)
    {

        $extras = Extra::where('event_id', $product->event_id)->get();

        return view('vendor.voyager.products.extras', compact('extras', 'product'));
    }

    public function ticketAddExtras(Ticket $ticket, Request $request)
    {

        $product = $ticket->product;
        $extras = Extra::where('event_id', $product->event_id)->get();
        return view('vendor.voyager.ticket.extras', compact('ticket', 'extras', 'product'));
    }

    public function ticketAddExtrasStore(Ticket $ticket, Request $request)
    {
        $data = [];
        $extras = $ticket->extras;

        foreach ($request->extras as $key => $extra) {

            if (isset($extra['checked'])) {
                if (isset($extras[$key])) {
                    $extras[$key]['qty'] = $extra['qty'];
                } else {
                    $extras[$key] = [
                        "id" => $key,
                        "qty" => $extra['qty'],
                        "name" => Extra::find($key)->display_name,
                        "used" => 0,
                    ];
                }
            } else {
                unset($extras[$key]);
            }
        }
        $ticket->extras = $extras;
        $ticket->save();
        return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Product added to ticket']);
    }

    public function productAddExtrasStore(Product $product, Request $request)
    {

        $data = [];
        foreach ($request->extras as $key => $extra) {

            if (isset($extra['checked'])) {
                $data[$key] = $extra['qty'];
            }
        }
        $product->extras = $data;
        $product->save();
        return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Extras updated']);
    }

    public function refund(Order $order)
    {
        if ($order->status == 1) {
            $order->update([
                'status' => 3,
                'refund_amount' => $order->total,
            ]);

            return back()->with([
                'message' => "Order amount has been refunded",
                'alert-type' => 'success',
            ]);
        } else {
            return back()->with([
                'message' => "Attempted to refund is failed",
                'alert-type' => 'error',
            ]);
        }
    }

    public function sendEmailOrder(Order $order, Request $request)
    {
        $ticket = null;
        $product = null;
        if ($request->filled('ticket')) {
            $ticket = Ticket::find($request->ticket);
        }
        if ($request->filled('product')) {
            $product = Product::find($request->product);
        }
        if ($order->payment_method == 'invite') {
            if ($product && $ticket) {
                Mail::to($order->billing->email)->send(new InviteDownload($order, $product, $ticket));
            } else {
                $products = $order->tickets->groupBy('product_id');

                foreach ($products as $key => $tickets) {
                    $product = Product::find($key);

                    Mail::to($order->billing->email)->send(new InviteDownload($order, $product, $ticket));
                }
            }
        } else {
            if ($product && $ticket) {
                Mail::to($order->user->email)->send(new TicketDownload($order, $product, $ticket));
            } else {
                $products = $order->tickets->groupBy('product_id');

                foreach ($products as $key => $tickets) {
                    $product = Product::find($key);

                    Mail::to($order->user->email)->send(new TicketDownload($order, $product, $ticket));
                }
            }
        }
        return redirect()->back()->with([
            'message' => 'Email sent successfully',
            'alert-type' => 'success',
        ]);
    }
    public function couponGenerate()
    {
        $products = Product::all();
        $events = Event::all();
        return view('vendor.voyager.coupons.coupon-add', compact('products', 'events'));
    }

    public function couponCreate(Request $request)
    {
        $request->validate([
            'discount' => 'required',
            'expire_at' => 'required',
            'limit' => 'required',
            'type' => 'required',
            'event_id' => 'required|exists:events,id',
        ]);

        for ($i = 0; $i < $request->quantity; $i++) {
            $coupon = Coupon::create([
                'code' => uniqid(),
                'discount' => $request->discount,
                'expire_at' => $request->expire_at,
                'limit' => $request->limit,
                'type' => $request->type,
                'event_id' => $request->event_id,
            ]);

            $coupon->products()->attach($request->product_id);
        }

        return redirect()->route('voyager.coupons.index')->with([
            'message' => 'Coupons Created Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function personalInviteForm(Product $product)
    {
        return view('vendor.voyager.products.invite', compact('product'));
    }

    protected function getUser($billing)
    {
        $email = $billing['email'] ?? null;
        $phone = $billing['phone'] ?? null;

        if ($phone) {
            // Attempt to find user by phone
            $user = User::where('contact_number', $phone)->first();

            // If no user is found by phone, create with a fake email
            if (!$user) {
                $user = User::create([
                    'name' => @$billing['name'] ,
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
            $user = User::where('email', $email)->first();

            // If no user is found by email, create with email provided
            if (!$user) {
                $user = User::create([
                    'name' => @$billing['name'] ,
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
                'name' => @$billing['name'] ,
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
    public function personalInvitePost(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required_without_all:phone|required_if:send_email,1|nullable',
            'phone' => 'required_without_all:email|required_if:send_message,1|nullable',
            'qty' => 'required|min:1',
            'send_email' => 'boolean',
            'send_message' => 'boolean',
        ]);

        try {
            $billing = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];
            $orderData = [
                'user_id' => $this->getUser($billing)->id,
                'billing' => $billing ,
                'subtotal' => 0,
                'discount' => 0,
                'discount_code' => 0,
                'tax' => 0,
                'total' => 0,

                'payment_method' => 'invite',
                'transaction_id' => Str::uuid(),
                'security_key' => Str::uuid(),
                'send_message' => $request->send_message ? true : false,
                'send_email' => $request->send_email ? true : false,
                'event_id' => $product->event->id,
            ];
            $order = Order::create($orderData);

            if ($product->quantity < $request->qty) {
                throw new Exception($product->name . ' is not available for this quantity');
            }

            $product->quantity -= $request->qty;
            $product->save();
            for ($i = 1; $i <= $request->qty; $i++) {
                $data = [
                    'user_id' => $orderData['user_id'],
                    'owner' => [
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                    ],
                    'event_id' => $product->event->id,
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'ticket' => uniqid(),
                    'price' => 0,
                    'dates' => $product->dates,
                    'type' => 'invite',
                ];

                if ($product->extras && count($product->extras)) {
                    $data['hasExtras'] = true;
                    $data['extras'] = collect($product->extras)->map(fn($qty, $key) => ['id' => $key, 'name' => Extra::find($key)->display_name, 'qty' => $qty, 'used' => 0])->toArray();
                }
                $order->tickets()->create($data);
            }
            $order->update([
                'status' => 1,
                'payment_status' => 1,
            ]);

            // Mail::to(request()->email)->send(new InviteDownload($order, $product, null));
            return redirect()->route('voyager.products.index')->with([
                'message' => 'Invite sent successfully',
                'alert-type' => 'success',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        } catch (Error $e) {
            return redirect()->route('voyager.products.index')->with([
                'message' => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    public function ticketCreatePhysical(Product $product)
    {
        $tickets = $product->physicalTickets->groupBy('group')->map(fn($tickets) => $tickets->count());

        return view('vendor.voyager.products.physical', compact('product', 'tickets'));
    }
    public function ticketCreatePhysicalPost(Product $product, Request $request)
    {
        try {
            DB::beginTransaction();
            $tickets = [];
            $extras = [];
            if ($product->extras && count($product->extras)) {
                $extras['hasExtras'] = true;
                $extras['extras'] = json_encode(collect($product->extras)->map(fn($qty, $key) => ['id' => $key, 'name' => Extra::find($key)->display_name, 'qty' => $qty, 'used' => 0])->toArray());
            }

            for ($i = 1; $i <= $request->qty; $i++) {
                $data = [
                    'event_id' => $product->event_id,
                    'product_id' => $product->id,
                    'group' => $request->name,
                    'type' => 'physical',
                    'ticket' => now()->format('ymdhis') . uniqid(),
                    'status' => 0,
                    'owner' => json_encode([
                        'name' => '',
                        'email' => '',
                        'phone' => '',
                    ]),
                    'price' => $product->price,
                    'dates' => json_encode($product->dates),
                    'created_at' => now(),

                ];
                $data = array_merge($data, $extras);
                array_push($tickets, $data);
            }

            Ticket::insert($tickets);

            DB::commit();
            return redirect()->back()->with([
                'message' => 'Physical ticket generation completed successfully',
                'alert_type' => 'success',
            ]);
        } catch (Exception | Error $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'message' => $e->getMessage(),
                'alert_type' => 'error',
            ]);
        }
    }

    public function ticketCreatePhysicalDownload(Product $product, Request $request)
    {
        $productName = preg_replace('/[\/\\\\]/', '-', strtolower(str_replace(' ', '-', $product->name)));
        $groupName = preg_replace('/[\/\\\\]/', '-', strtolower(str_replace(' ', '-', $request->group)));
        $name = $productName . '-' . $groupName . '-tickets-' . now()->format('ymdhs');
        $tickets = $product->physicalTickets()->where('group', $request->group)->get()->map(fn($ticket) => [
            'id' => $ticket->id,
            'ticket' => $ticket->ticket,
            'event' => $ticket->event->name,
            'product' => $ticket->product->name,
            'dates' => implode(', ', $ticket->dates),
        ]);

        return Excel::download(new TicketExport($tickets), $name . '.xlsx');

    }
    public function ticketCreatePhysicalDestroy(Product $product, Request $request)
    {
        $tickets = $product->physicalTickets()->where('group', $request->group)->delete();
        return redirect()->back()->with([
            'message' => 'Physical ticket delete  successfully',
            'alert_type' => 'success',
        ]);
    }
    public function orderMarkPay(Order $order)
    {
       $order->payment_status = 1;
       $order->status = 1;
       $order->save();

   
       $toco = new TOCOnlineService;
       $response = $toco->createCommercialSalesDocument($order);
       $order->invoice_id = $response['id'];
       $order->invoice_url = $response['public_link'];
       $order->invoice_body = json_encode($response);
       $order->save();
       $response = $toco->sendEmailDocument($order, $response['id']);
       return back();
    }
}
