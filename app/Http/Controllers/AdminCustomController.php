<?php

namespace App\Http\Controllers;

use App\Mail\TicketDownload;
use App\Models\Coupon;
use App\Models\Event;
use App\Models\Extra;
use App\Models\Invite;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ticket;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


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
        $event = Event::find($request->event_id);

        for ($i = 0; $i < $request->quantity; $i++) {
            $coupon = Coupon::create([
                'code' => uniqid(),
                'discount' => $request->discount,
                'expire_at' => $request->expire_at,
                'quantity' => 1,
                'limit' => $request->limit,
                'type' => $request->type,
                'event_id' => $event->id,
            ]);


            $coupon->products()->attach($request->product_id);
        }

        return redirect()->route('voyager.coupons.index')->with([
            'message' => 'Coupons Created Successfully',
            'alert-type' => 'success',
        ]);
    }
}
