<?php

namespace App\Http\Controllers;

use App\Exports\TicketExport;
use App\Mail\TicketDownload;
use App\Models\Coupon;
use App\Models\Event;
use App\Models\Extra;
use App\Models\Invite;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ticket;
use Error;
use Exception;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        foreach ($request->product as $key => $product) {

            if (isset($product['checked'])) {
                $data[$key] = ['quantity' => $product['qty']];
            }
        }

        $invite->products()->sync($data);
        return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Product attached on invite']);
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
                        "used" => 0
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
            ]);

            return back()->with([
                'message'    => "Refund successfully",
                'alert-type' => 'Success',
            ]);
        } else {
            return back()->with([
                'message'    => "Refund danger",
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
        if ($product && $ticket) {
            Mail::to($order->user->email)->send(new TicketDownload($order, $product, $ticket));
        } else {
            $products = $order->tickets->groupBy('product_id');

            foreach ($products as $key => $tickets) {
                $product = Product::find($key);

                Mail::to($order->user->email)->send(new TicketDownload($order, $product, $ticket));
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

    public function personalInvitePost(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'qty' => 'required|min:1',
        ]);

        try {


            $order = Order::create([
                'user_id' =>  null,
                'billing' => [
                    'name' => $request->name,
                    'email' => $request->email,
                ],
                'subtotal' => 0,
                'discount' => 0,
                'discount_code' => 0,
                'tax' => 0,
                'total' => 0,
                'status' => 1,
                'payment_status' => 1,
                'payment_method' => 'invite',
                'transaction_id' => Str::uuid(),
                'security_key' => Str::uuid(),
                'event_id' => $product->event->id,
            ]);

            if ($product->quantity < $request->qty) throw new Exception($product->name . ' is not available for this quantity');
            $product->quantity -= $request->qty;
            $product->save();
            for ($i = 1; $i <= $request->qty; $i++) {
                $data = [
                    'user_id' =>  null,
                    'owner' => [
                        'name' => $request->name,
                        'email' => $request->email,
                    ],
                    'event_id' => $product->event->id,
                    'product_id' => $product->id,
                    'order_id' => $order->id,
                    'ticket' => uniqid(),
                    'price' => $product->price,
                    'dates' => $product->dates
                ];

                if ($product->extras && count($product->extras)) {
                    $data['hasExtras'] = true;
                    $data['extras'] = collect($product->extras)->map(fn($qty, $key) => ['id' => $key, 'name' => Extra::find($key)->display_name, 'qty' => $qty, 'used' => 0])->toArray();
                }
                $order->tickets()->create($data);
            }

            Mail::to(request()->email)->send(new TicketDownload($order, $product, null));
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
            return redirect()->back()->route('voyager.products.index')->with([
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
                $data =  [
                    'event_id' => $product->event_id,
                    'product_id' => $product->id,
                    'group' => $request->name,
                    'type' => 'physical',
                    'ticket' =>  now()->format('ymdhis') . uniqid(),
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
        } catch (Exception  | Error $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'message' => $e->getMessage(),
                'alert_type' => 'error',
            ]);
        }
    }

    public function ticketCreatePhysicalDownload(Product $product, Request $request)
    {
        $tickets = $product->physicalTickets()->where('group', $request->group)->get()->map(fn($ticket) => ['id' => $ticket->id, 'ticket' => $ticket->ticket, 'event' => $ticket->event->name, 'product' => $ticket->product->name, 'dates' => implode(', ', $ticket->dates)]);
        $name = strtolower(str_replace(' ', '-', $product->name)) . '-' . strtolower(str_replace(' ', '-', $request->group)) . '-' . 'tickets' . '-' . now()->format('ymdhs');
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
}
