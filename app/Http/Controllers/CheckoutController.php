<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Magazine;
use App\Models\MagazineOrder;
use App\Models\MagazineOrderArchive;
use App\Models\Product;
use App\Services\CheckoutService;
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

    public function magazineStore(Magazine $magazine, Request $request)
    {

        $user = auth()->user();
        $user->update($request->only('name', 'l_name', 'vatNumber', 'contact_number', 'address'));
        $cart = Cart::session($magazine->slug)->getContent();

        $magazine = MagazineOrder::create([
            'user_id' => $user->id,
            'subtotal' => Cart::getSubtotal(),
            'total' => Cart::getTotal(),
        ]);
        foreach ($cart as $item) {
            // dd($item->attributes['Subsciption']);
            MagazineOrderArchive::create([
                'magazine_order_id' => $magazine->id,
                'archive_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price,

            ]);
            $magazine->update([
                'type' => $item->attributes['Subsciption'] . ' ' . 'subscription',
            ]);
        }
        Cart::clear();
        return redirect()->route('magazines.index')
            ->with('success_msg', 'Order created successfully.');
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
