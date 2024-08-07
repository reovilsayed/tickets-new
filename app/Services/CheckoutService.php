<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Order;
use App\Services\Payment\EasyPay;
use Cart;
use Exception;
use Sohoj;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutService
{

    protected $cart;
    protected $event;
    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->cart = Cart::session($event->slug)->getContent();
    }

    public static function  create(Event $event, Request $request)
    {
        return (new self($event))->generate($request);
    }


    public function generate($request)
    {
        $request->validate([
            'name' => ['required'],
            'vatNumber' => ['nullable'],
            'address' => ['nullable'],
        ]);


        $order = $this->createOrder();

        foreach ($this->cart as $item) {
            if ($item->model->quantity < $item->quantity) throw new Exception($item->model->name . ' is not available for this quantity');
            $item->model->quantity -= $item->quantity;
            $item->model->save();
            for ($i = 1; $i <= $item->quantity; $i++) {
                $order->tickets()->create([
                    'user_id' => auth()->id() ?? null,
                    'owner' => $this->billingObject(),
                    'event_id' => $item->model->event_id,
                    'product_id' => $item->id,
                    'order_id' => $order->id,
                    'ticket' => uniqid(),
                    'price' => $item->price,
                    'dates' => $item->model->dates,

                ]);
            }
        }
        $payment = EasyPay::createPaymentLink($order);

        Log::info('This is order info');
        Log::info($payment);
        Log::info('This is order end info');
        $order->payment_link = $payment['url'];
        $order->payment_id = $payment['id'];
        $order->save();


        return $order;
    }


    protected function createOrder()
    {
        $total = (Cart::session($this->event->slug)->getSubTotal() + Sohoj::tax()) - Sohoj::discount();

        return Order::create([
            'user_id' => auth()->id() ?? null,
            'billing' => $this->billingObject(),
            'subtotal' => Cart::session($this->event->slug)->getSubTotal(),
            'discount' => Sohoj::round_num(Sohoj::discount()),
            'discount_code' => Sohoj::discount_code(),
            'tax' => Sohoj::round_num(Sohoj::tax()),
            'total' => $total,
            'status' => 4,
            'payment_method' => 'easypay.pt',
            'transaction_id' => Str::uuid()
        ]);
    }

    // protected function createOrder()
    // {
    //     $total = 
    // }

    protected function billingObject()
    {
        return [
            'name' => request()->name,
            'vatNumber' => request()->vatNumber ?? null,
            'address' => request()->address,
        ];
    }
}
