<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Event;
use App\Models\Extra;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
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
    protected $invite;
    protected $isFree;
    protected $user;
    public function __construct(Event $event, $isFree = false, $invite, User $user = null)
    {
        $this->event = $event;
        $this->isFree = $isFree;
        $this->invite = $invite;
        $this->user = $user;
        $this->cart = Cart::session($event->slug)->getContent();
    }

    public static function create(Event $event, Request $request, $isFree = false, $invite = null, User $user = null)
    {
        return (new self($event, $isFree, $invite, user: $user))->generate($request);
    }


    public function generate($request)
    {
        $request->validate([
            'name' => ['required'],
            'vatNumber' => ['nullable'],
            'address' => ['nullable'],
        ]);

        $order = $this->createOrder();


        if ($this->isFree) {
            foreach ($request->tickets as $id => $quantity) {

                if ($this->invite) {
                    if ($this->invite->products()->find($id)->pivot->quantity < $quantity) throw new Exception($this->invite->products()->find($id)->name . ' is not available for this quantity');
                    $item = $this->invite->products()->find($id);
                    $data = [
                        'quantity' =>  $item->pivot->quantity - $quantity,
                        'used' => $item->pivot->used + $quantity
                    ];

                    $this->invite->products()->updateExistingPivot($id, $data);
                } else {
                    $item = Product::find($id);
                }

                for ($i = 1; $i <= $quantity; $i++) {
                    $data = [
                        'invite_id' => $this->invite ? @$this->invite?->id : null,
                        'user_id' =>  $this->user ? $this->user->id : auth()->id() ?? null,
                        'owner' => $this->inviteBillingObject(),
                        'event_id' => $this->event->id,
                        'product_id' => $id,
                        'order_id' => $order->id,
                        'ticket' => uniqid(),
                        'price' => 0,
                        'dates' => $item->dates,
                        'type' => 'invite',
                        'active'=> $item->paid_invite ? 0 : 1
                    ];

                    if ($item->extras && count($item->extras)) {
                        $data['hasExtras'] = true;
                        $data['extras'] = collect($item->extras)->map(fn($qty, $key) => ['id' => $key, 'name' => Extra::find($key)->display_name, 'qty' => $qty, 'used' => 0])->toArray();
                    }
                    $order->tickets()->create($data);
                }
            }
            $order->update(
                [
                    'status' => 1,
                    'payment_status' => 1,
                ]
            );
        } else {
            $coupon = Coupon::where(
                'code',
                session()->get('discount_code'),
            )->first();
            if ($coupon) {
                $discountedProduct = $this->cart->filter(
                    fn($item) => $coupon->getProducts()->contains($item->id),
                );
                $discountPerUnit = number_format(
                    session()->get('discount') / $discountedProduct->sum('quantity'),
                    4,
                );
            } else {
                $discountedProduct = collect([]);
                $discountPerUnit = 0;
            }

            foreach ($this->cart as $key => $item) {
                if ($item->model->quantity < $item->quantity) throw new Exception($item->model->name . ' is not available for this quantity');

                for ($i = 1; $i <= $item->quantity; $i++) {
                    $data = [
                        'user_id' => $this->user ? $this->user->id : auth()->id() ?? null,
                        'owner' => $this->billingObject(),
                        'event_id' => $this->event->id,
                        'product_id' => $item->id,
                        'order_id' => $order->id,
                        'ticket' => uniqid(),
                        'price' => isset($discountedProduct[$key]) ? $item->price - $discountPerUnit : $item->price,
                        'dates' => $item->model->dates,
                        'type' => 'web'
                    ];

                    if ($item->model->extras && count($item->model->extras)) {
                        $data['hasExtras'] = true;
                        $data['extras'] = collect($item->model->extras)->map(fn($qty, $key) => ['id' => $key, 'name' => Extra::find($key)->display_name, 'qty' => $qty, 'used' => 0])->toArray();
                    }
                    $order->tickets()->create($data);
                }
            }
        }

        if (!$this->isFree) {
            $payment = EasyPay::createPaymentLink($order);
            Log::info('payment link created'. json_encode($payment));
            $order->payment_link = $payment['url'];
            $order->payment_id = $payment['id'];
        }


        $order->save();


        return $order;
    }


    protected function createOrder()
    {
        request()->validate([
            'contact_number' => 'required_if:send_message,1',
            'name' => 'required',
            'vatNumber' => 'nullable',
            'address' => 'nullable',
        ]);
        if ($this->isFree) {
            $data = [
                'invite_id' => $this->invite ? @$this->invite?->id : null,
                'user_id' => $this->user ? $this->user->id : null,
                'billing' => $this->inviteBillingObject(),
                'subtotal' => 0,
                'discount' => 0,
                'discount_code' => null,
                'tax' => 0,
                'total' => 0,
                'payment_method' => 'invite',
                'transaction_id' => 0,
                'security_key' => Str::uuid(),
                'event_id' => $this->event->id,
                'send_message' => request()->send_message ? true : false,
                'send_email' => request()->send_email ? true : false
            ];
        } else {
            $tax = $this->cart->map(function ($product) {
                return  $product->quantity * $product->model->totalTax();
            })->sum();

            $total = (Cart::session($this->event->slug)->getSubTotal() + Sohoj::tax()) - Sohoj::discount();
            $data = [
                'user_id' => $this->user ? $this->user->id : auth()->id() ?? null,
                'billing' => $this->billingObject(),
                'subtotal' => Cart::session($this->event->slug)->getSubTotal(),
                'discount' => Sohoj::round_num(Sohoj::discount()),
                'discount_code' => Sohoj::discount_code(),
                'tax' => $tax,
                'total' => $total,
                'status' => 0,
                'payment_method' => 'easypay.pt',
                'transaction_id' => Str::uuid(),
                'security_key' => Str::uuid(),
                'event_id' => $this->event->id,
                'send_message' => request()->send_message,
                'send_email' => true,
            ];
        }

        return Order::create($data);
    }


    protected function billingObject()
    {
        return [
            'name' => request()->name,
            'vatNumber' => request()->vatNumber ?? '',
            'address' => request()->address,
            'phone' => request()->contact_number,
        ];
    }
    protected function inviteBillingObject()
    {
        return [
            'name' => request()->name,
            'email' => request()->email,
            'phone' => request()->contact_number
        ];
    }
}
