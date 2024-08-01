<?php

namespace App\Services;

use App\Models\Order;
use Cart;
use Exception;
use Sohoj;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CheckoutService
{

    protected $cart;
    public function __construct()
    {
        $this->cart = Cart::getContent();
    }

    public static function  create(Request $request)
    {
        return (new self)->generate($request);
    }


    public function generate($request)
    {



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
                    'dates' => $item->model->dates
                ]);
            }
        }


        return $order;
    }


    protected function createOrder()
    {
        $total = (Cart::getSubTotal() + Sohoj::tax()) - Sohoj::discount();
        return Order::create([
            'user_id' => auth()->id() ?? null,
            'billing' => $this->billingObject(),
            'subtotal' => Cart::getSubTotal(),
            'discount' => Sohoj::round_num(Sohoj::discount()),
            'discount_code' => Sohoj::discount_code(),
            'tax' => Sohoj::round_num(Sohoj::tax()),
            'total' => $total,
            'status' => 4,
        ]);
    }

    // protected function createOrder()
    // {
    //     $total = 
    // }

    protected function billingObject()
    {
        return json_encode([
            'first_name' => request()->first_name,
            'last_name' => request()->last_name,
            'email' => request()->email,
            'phone' => request()->phone,
        ]);
    }
}
