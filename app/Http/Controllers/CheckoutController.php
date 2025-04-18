<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Magazine;
use App\Models\MagazineCoupon;
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
use Illuminate\Support\Facades\Validator;
use Sohoj;

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

            $cart = Cart::session($magazine->slug)->getContent();

            $validator = Validator::make($request->all(), [
                'vatNumber' => 'required|numeric',
                'name' => 'required|string|max:255',
                'l_name' => 'required|string|max:255',
                'contact_number' => 'required|string|max:20',
                'address' => 'required|string|max:255',
            ]);

            // Conditionally add shipping validation if "shipping" exists
            if ($request->has('shipping')) {
                $validator->addRules([
                    'shipping.recipient_name' => 'required|string|max:255',
                    'shipping.company' => 'nullable|string|max:255',
                    'shipping.street_address' => 'required|string|max:255',
                    'shipping.apartment' => 'nullable|string|max:255',
                    'shipping.city' => 'required|string|max:255',
                    'shipping.state_province' => 'required|string|max:255',
                    'shipping.postal_code' => 'required|string|max:20',
                    'shipping.phone' => 'required|string|max:20',
                    'shipping.email' => 'required|email|max:255',
                    'shipping.special_instructions' => 'nullable|string|max:1000',
                ]);
            }


            $validated = $validator->validate();

            if (isset($validated['shipping'])) {
                $code = Cart::session($magazine->slug)->getConditionsByType('shipping')->first()->getAttributes()['country_code'];
                $validated['shipping']['country'] = Sohoj::getCountries()[$code];
                $validated['shipping']['country_code'] = $code;
            }



            $user = auth()->user();

            $user->update($request->only('name', 'l_name', 'vatNumber', 'contact_number', 'address'));




            $order = MagazineOrder::create([
                'user_id' => $user->id,
                'transaction_id' => 'magazine_' . uniqid(),
                'subtotal' => Cart::session($magazine->slug)->getSubTotalWithoutConditions(),
                'total' => Cart::session($magazine->slug)->getTotal(),
                'shipping' => Cart::session($magazine->slug)->getConditionsByType('shipping')?->sum(fn($condition) => $condition->getCalculatedValue(Cart::session($magazine->slug)->getSubtotal())),
                'discount' => Cart::session($magazine->slug)->getCondition('Coupon')?->getCalculatedValue(Cart::session($magazine->slug)->getSubtotal()),
                'discount_code' => MagazineCoupon::where('code', Cart::session($magazine->slug)->getCondition('Coupon')?->getAttributes()['code'])->value('id'),
                'billing' => [
                    'name' => $validated['name'] . ' ' . $validated['l_name'],
                    'vatNumber' => $validated['vatNumber'] ?? '',
                    'address' => $validated['address'],
                    'phone' => $validated['contact_number'],
                ],
                'shipping_info' => json_encode($validated['shipping']),
                'currency' => 'EUR',
            ]);
            foreach ($cart as $item) {

                $order->items()->create([
                    'itemable_id' => $item->id,
                    'itemable_type' => get_class($item->model),
                    'unit_price' => $item->model->price,
                    'total_price' => $item->price,
                    'quantity' => $item->quantity,
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
            Cart::session($magazine->slug)->clearCartConditions();
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
