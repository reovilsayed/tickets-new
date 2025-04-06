<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Magazine;
use App\Models\MagazineOrder;
use App\Models\MagazineOrderArchive;
use App\Models\Product;
use App\Services\CheckoutService;
use App\Services\Payment\EasyPay;
use Cart;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function store(Event $event, Request $request)
    {


        try {
            DB::beginTransaction();
            $order = CheckoutService::create($event, $request);
            DB::commit();


            Cart::session($event->slug)->clear();
            session()->forget('discount');
            session()->forget('discount_code');

            return redirect($order->payment_link)->with('success_msg', 'Order create successfull');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function magazineStore(Magazine $magazine, Request $request)
    {
        try {
            $user = auth()->user();
           
            $user->update($request->only('name', 'l_name', 'vatNumber', 'contact_number', 'address'));

            $cart = Cart::session($magazine->slug)->getContent();



            $order = MagazineOrder::create([
                'user_id' => $user->id,
                'transaction_id' => 'magazine_' . uniqid(),
                'subtotal' => Cart::session($magazine->slug)->getSubtotal(),
                'total' => Cart::session($magazine->slug)->getTotal(),
                'billing'=>[
                    'name' => request()->name.' '.request()->l_name,
                    'vatNumber' => request()->vatNumber ?? '',
                    'address' => request()->address,
                    'phone' => request()->contact_number,
                ]
            ]);
            foreach ($cart as $item) {

                $order->items()->create([
                    'itemable_id' => $item->id,
                    'itemable_type' => get_class($item->model),
                    'unit_price' => $item->model->price,
                    'total_price' => $item->price,
                    'quantity'=>$item->quantity,
                    'details' => json_encode($item->model)
                ]);

                $order->update([
                    'type' => $item->attributes['type'],
                ]);
            }

            $payment = EasyPay::createMagazinePaymentLink($order);
            Log::info('payment link created' . json_encode($payment));
            $order->payment_link = $payment['url'];
            $order->payment_id = $payment['id'];


            $order->save();

            Cart::session($magazine->slug)->clear();
            return redirect($order->payment_link);
        } catch (Exception | Error $e) {
            return redirect()->route('magazines.index')
                ->withErrors($e->getMessage());
        }
    }

    // protected function notification($user, $shop)
    // {
    //     Notification::create([
    //         'url' => env('APP_URL') . '/vendor/dashboard/orders/index',
    //         'title' => 'Order Created',
    //         'shop_id' => $shop,
    //     ]);
    // }

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
}
