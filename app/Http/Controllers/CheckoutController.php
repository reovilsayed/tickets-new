<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\Event;
use App\Models\Notification;
use Sohoj;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\User;
use App\Services\CheckoutService;
use App\Services\Payment\EasyPay;
use Cart;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
