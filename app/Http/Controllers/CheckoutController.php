<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\Notification;
use Sohoj;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use KaziRayhan\VivaWallet\Customer;
use KaziRayhan\VivaWallet\Enums\PaymentMethod;
use KaziRayhan\VivaWallet\Enums\RequestLang;
use KaziRayhan\VivaWallet\Facades\VivaWallet;
use KaziRayhan\VivaWallet\Payment;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {


        $shipping = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required', 'max:40'],
            'email' => ['required', 'max:40', 'email'],
            'phone' => ['required'],
            'address' => ['nullable'],
            'country' => ['nullable'],
            'city' => ['nullable'],
            'post_code' => ['nullable', 'numeric'],
            'terms' => ['required'],
        ]);
        unset($shipping['terms']);

        if ($this->productsAreNoLongerAvailable()) {

            return back()->withErrors('Sorry! One of the items in your cart is no longer Available!');
        }
        $i = 0;
        $parent = null;
        foreach (Cart::getContent() as $item) {
            $total = (Cart::getSubTotal() + Sohoj::tax()) - Sohoj::discount();
            $trnxid = $this->generateOrderNumber();
            $customer = new Customer(
                $email = auth()->user()->email,
                $fullName = auth()->user()->name . ' ' . auth()->user()->l_name,
                $phone = null,
                $countryCode = 'DR',
                $requestLang = RequestLang::English,
            );


           d

           

            $data = [
                'user_id' => auth()->user() ? auth()->user()->id : null,
                'shop_id' => $item->model->shop_id,
                'product_id' => $item->model->id,
                'shipping' => json_encode($shipping),
                'subtotal' => Cart::getSubTotal(),
                'discount' => Sohoj::round_num(Sohoj::discount()),
                'discount_code' => Sohoj::discount_code(),
                'tax' => Sohoj::round_num(Sohoj::tax()),
                'total' => $total,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'status'=> 4,
                // 'payment_method_title' => '',
                // 'payment_method' => $paymentmethod,

            ];

            $orderProduct = [
                'quantity' => $item->quantity,
                'product_id' => $item->model->id,
                'price' => $item->price,
                'total_price' => $item->price * $item->quantity,
                'status'=>4,
                // 'shop_id' => $item->model->shop_id,
            ];
            $data['order_number'] = $trnxid;
            $parent = Order::create($data);
            if ($parent) {
                unset($data['payment_method_title']);
                unset($data['payment_method']);
                $data['parent_id'] = $parent->id;
                for ($i = 0; $i < $item->quantity; $i++) {
                    $data['order_number'] = $this->generateOrderNumber();
                    $order = Order::create($data);
                    $orderProduct['order_id'] = $order->id;
                    OrderProduct::create($orderProduct);
                }
            }
        }

        $this->decreaseQuantities();
        
        Cart::clear();
        session()->forget('discount');
        session()->forget('discount_code');
        return redirect()->route('thankyou')->with('success_msg', 'Order create successfull ');
    }

    protected function decreaseQuantities()
    {
        foreach (Cart::getContent() as $item) {
            $product = Product::find($item->model->id);
            $product->increment('total_sale');
            $product->update(['quantity' => $product->quantity - $item->quantity]);
        }
    }
    protected function notification($user, $shop)
    {
        Notification::create([
            'url' => env('APP_URL') . '/vendor/dashboard/orders/index',
            'title' => 'Order Created',
            'shop_id' => $shop,
        ]);
    }

    protected function productsAreNoLongerAvailable()
    {
        foreach (Cart::getContent() as $item) {
            $product = Product::find($item->model->id);
            if ($product->quantity < $item->quantity) {
                return true;
            }
        }
        return false;
    }
    public function userAddress(Request $request)
    {

        Address::create([
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'post_code' => $request->post_code,
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success_msg', 'Address create successfull ');
    }
    protected function generateOrderNumber()
    {

        $unique = false;
        $orderNumber = null;
        while (!$unique) {
            $orderNumber = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT);
            $existingOrder = Order::where('order_number', $orderNumber)->first();

            if (!$existingOrder) {
                $unique = true;
            }
        }
        return $orderNumber;
    }
}
