<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Mail\OfferEmail;
use App\Models\Address;
use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Prodcat;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopPolicy;
use App\Models\User;
use App\Models\Verification;
use App\Rules\MatchOldPassword;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stripe\Charge;
use Stripe\Price;
use Stripe\Product as StripeProduct;
use Stripe\Stripe;

class SellerPagesController extends Controller
{
    public function dashboard()
    {
        $shop = auth()->user()->shop;
        $customer = User::filter()->get();

        $totalSell = Order::where('shop_id', $shop->id)->filter()->sum('total');
        $products = Product::whereNull('parent_id')->where('shop_id', $shop->id)
            ->when(request('product_search'), function ($query) {
                $query->where('name', 'LIKE', "%" . request('product_search') . "%");
            })->latest()->limit(5)->get();

        $latest_orders =  Order::where('shop_id', $shop ? $shop->id : ' ')
            ->when(request('order_search'), function ($query) {
                $query->where('name', 'LIKE', "%" . request('order_search') . "%");
            })->limit(5)->get();
        $offers = Offer::where('shop_id', $shop->id)->latest()->get();
        $last15daysorders = Order::where('shop_id', $shop->id)
        ->groupBy(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'))
        ->select(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as formatted_date'), DB::raw('count(*) as order_count'))
        ->get();
        
        




        return view('auth.seller.dashboard', compact('latest_orders', 'products', 'offers', 'totalSell', 'customer', 'last15daysorders'));
    }
    public function shop()
    {

        return view('auth.seller.shop_profile');
    }
    public function ordersIndex()
    {
        $latest_orders =  Order::where('shop_id', auth()->user()->shop->id)->whereNotNUll('parent_id')->latest()->get();

        return view('auth.seller.order.index', compact('latest_orders'));
    }
    public function orderView($ordernumber)
    {

        $order=Order::where('order_number',$ordernumber)->firstOrFail();
        return view('auth.seller.order.view', compact('order'));
    }
    public function invoice(Order $order)
    {
        return view('auth.seller.order.invoice', compact('order'));
    }
    public function setting()
    {

        // $status = $this->subscriptionStatus();
        return view('auth.seller.setting');
    }
    function ChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success_msg', 'Password changed successfully');
    }
    public function shopStore(Request $request)
    {

        $request->validate([
            'name' => ['nullable', 'max:40'],
            'logo' => ['nullable'],
            'banner' => ['nullable'],
            'email' => ['nullable', 'max:40', 'email'],
            'phone' => ['nullable', 'max:40'],
            'description' => ['nullable', 'max:1000'],
            'short_description' => ['nullable', 'max:300'],
            'tags' => ['nullable', 'max:60'],
            // 'company_name' => ['required', 'max:100'],
            // 'company_registration' => ['required', 'max:100'],

            'city' => ['nullable', 'max:50'],
            'country' => ['nullable', 'max:50'],
            'post_code' => ['nullable','numeric'],
            'state' => ['nullable', 'max:20'],

        ]);

        // if ($request->file('logo')) {
        //     $logo = $request->logo->store("logos");
        // } else {
        //     $logo = auth()->user()->shop ? auth()->user()->shop->logo : null;
        // }
        // if ($request->file('banner')) {
        //     $banner = $request->banner->store("banners");
        // } else {
        //     $banner = auth()->user()->shop ? auth()->user()->shop->banner : null;
        // }


        $shop = Shop::updateOrCreate([

            'user_id' => auth()->user()->id,
        ], [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'tags' => $request->tags,
            'company_name' => $request->company_name,
            'company_registration' => $request->company_registration,
            'city' => $request->city,
            'state' => $request->state,
            'post_code' => $request->post_code,
            'country' => $request->country,

        ]);

        $slug = Str::slug($shop->name);
        if (shop::where('slug', $slug)->first()) {
            $slug = $slug . '-' . $shop->id;
        }
        $shop->update([
            'slug' =>  $slug,
        ]);



        return back()->with('success_msg', 'Success! Your shop has been updated/created');
    }
    public function shippingUrl(Request $request)
    {

        $order = Order::where('id', $request->order_id)->firstOrFail();
        $order->update(
            [
                'shipping_url' => $request->shipping_url,
                'shipping_method' => $request->shipping_method,
                'shipping_date' => $request->shipping_date,
                'status' => 2,
            ]
        );
        return back()->with('success_msg', 'Shop has been created!');
    }
    public function banner()
    {
        return view('auth.seller.banner');
    }
    public function bannerStore(Request $request)
    {
        $shop = auth()->user()->shop;
        $shop->createMetas($request->meta);

        return back()->with('success_msg', 'Banner has been created!');
    }
    public function shopSocialLinksStore(Request $request)
    {
        $request->validate([
            'meta.*.facebook' => 'nullable|string|max:100|url',
            'meta.*.linkedin' => 'nullable|string|max:100|url',
            'meta.*.instagram' => 'nullable|string|max:100|url',
            'meta.*.twitter' => 'nullable|string|max:100|url',
        ]);
        $shop = auth()->user()->shop;
        $shop->createMetas($request->meta);


        return back()->with('success_msg', 'Social Links has been Added!');
    }
    public function shopPolicy()
    {
        return view('auth.seller.shopPolicy');
    }
    public function shopPolicyStore(Request $request)
    {
        $shopPolicy = ShopPolicy::updateOrCreate([
            'shop_id' => auth()->user()->shop->id,
        ], [
            'delivery' => $request->delivery,
            'payment_option' => $request->payment_option,
            'return_exchange' => $request->return_exchange,
            'cancellation' => $request->cancellation,
        ]);

        return back()->with('success_msg', 'shop Policy has been created!');
    }
    public function offers()
    {
        $offers = Offer::where('shop_id', auth()->user()->shop->id)->latest()->get();
        return view('auth.seller.offers', compact('offers'));
    }
    public function offerAccept(Offer $offer)
    {

        $offer->update([
            'status' => 1,
            'is_offer' => 1,
        ]);
        $this->notification($offer->user_id, auth()->user()->shop->id, 'Offer Accpeted', '/user/dashboard/offers');
        Mail::to($offer->user->email)->send(new OfferEmail($offer));
        return back()->with('success_msg', 'Offer Accepted!');

        $offers = Offer::where('shop_id', auth()->user()->shop->id)->latest()->get();
        return view('auth.seller.offers');
    }
    public function offerDecline(Offer $offer)
    {

        $offer->update([
            'status' => 2,
        ]);
        $this->notification($offer->user_id, auth()->user()->shop->id, 'Offer Decline', '/user/dashboard/offers');
        return back()->with('success_msg', 'Offer Declined!');



        $offers = Offer::where('shop_id', auth()->user()->shop->id)->latest()->get();
        return view('auth.seller.offers');
    }
    public function orderSeen()
    {

        if (auth()->user()->role_id == 3) {
            $unseenOrders = Order::where('seen', false)->where('shop_id', auth()->user()->shop->id)->get();
            foreach ($unseenOrders as $unseenOrder) {
                $unseenOrder->update([
                    'seen' => true,
                ]);
            }
            return redirect()->route('vendor.ordersIndex');
        } else {
            $unseenOrders = Order::where('seen', false)->where('user_id', auth()->user()->id)->get();
            foreach ($unseenOrders as $unseenOrder) {
                $unseenOrder->update([
                    'seen' => true,
                ]);
            }
            return redirect()->route('user.ordersIndex');
        }
    }
    public function orderDeliver(Request $request, Order $order)
    {
        // Update the order status
        if ($order->status !== 3 && $order->shop_id == auth()->user()->shop->id) {
            $order->update([
                'status' => 4,
            ]);
        }
        $this->notification($order->user_id, auth()->user()->shop->id, 'Order Delivered', '/user/dashboard/orders/index');

        return back()->with('success_msg', 'Order has been delivered!');
    }
    public function orderCancel(Request $request, Order $order)
    {
        // Update the order status
        if ($order->status !== 3 && $order->shop_id == auth()->user()->shop->id) {
            $order->update([
                'status' => 3,
            ]);
        }
        $this->notification($order->user_id, auth()->user()->shop->id, 'Order Canceled', '/user/dashboard/orders/index');

        return back()->with('success_msg', 'Order has been delivered!');
    }
    public function orderApprove(Request $request, Order $order)
    {
        // Update the order status
        if ($order->status == 0 && $order->shop_id == auth()->user()->shop->id) {
            $order->update([
                'status' => 1,
            ]);
        }
        $this->notification($order->user_id, auth()->user()->shop->id, 'Order Canceled', '/user/dashboard/orders/index');

        return back()->with('success_msg', 'Order has been delivered!');
    }

    public function logoCover(Request $request)
    {
        if ($request->file('logo')) {
            if (auth()->user()->shop) {
                $oldLogo = auth()->user()->shop->logo; // get the old logo file name
                if ($oldLogo) {
                    Storage::delete($oldLogo); // delete the old logo file
                }
            }
            Shop::updateOrCreate(['user_id' => auth()->user()->id], [
                'logo' => $request->logo->store("logos"),
            ]);
            return back()->with('success_msg', 'Logo upload successfully');
        }

        if ($request->file('banner')) {
            if (auth()->user()->shop) {
                $oldBanner = auth()->user()->shop->banner; // get the old banner file name
                if ($oldBanner) {
                    Storage::delete($oldBanner); // delete the old banner file
                }
            }
            Shop::updateOrCreate(['user_id' => auth()->user()->id], [
                'banner' => $request->banner->store("banners"),
            ]);
            return back()->with('success_msg', 'Banner upload successfully');
        }
    }
    public function settings()

    {

        return view('auth.seller.settings');
    }
    public function generalInfoUpdate(Request $request)
    {

        $data = $request->validate(
            [
                "tax_no" => "required",

            ]
        );
        auth()->user()->verification()->update([
            'tax_no' => $request->tax_no,

        ]);

        return back()->with('success_msg', 'General information updated successfully');
    }
    public function bankInfoUpdate(Request $request)
    {
        $data = $request->validate(
            [
                // "ac_holder_name" => "required",
                // "rtn" => "required",
                // "bank_account_number" => "required|confirmed",
                "paypal"=>"required|email",
            ]
        );
        auth()->user()->verification()->updateOrCreate(
            ['user_id'=>auth()->id()],[
            // 'ac_holder_name' => $request->ac_holder_name,
            // 'rtn' => $request->rtn,
            // 'bank_ac' => $request->bank_account_number,
            'paypal' => $request->paypal,
        ]);

        return back()->with('success_msg', 'Bank information updated successfully');
    }
    public function shopAddressUpdate(Request $request)
    {
         auth()->user()->createMetas($request->meta);

        // Address::where('user_id', auth()->user()->id)->update($data);

        return back()->with('success_msg', 'Addresses updated successfully');
    }
    public function charges()
    {
        $charges = Auth()->user()->invoices();
        $status = $this->subscriptionStatus();
        return view('auth.seller.charges', compact('charges','status'));
    }
    public function charge($charge)
    {
        $charge = auth()->user()->findInvoice($charge);
        return view('auth.seller.charge_invoice', compact('charge'));
    }
    public function shopMenuStore(Request $request)
    {
        $shop = auth()->user()->shop;
        $shop->createMetas($request->meta);
        return back()->with('success_msg', 'Shop Menu has been Added!');
    }

    protected function notification($user, $shop, $title, $url)
    {
        Notification::create([
            'url' => env('APP_URL') . $url,
            'title' => $title,
            'user_id' => $user,
        ]);
    }
    public function cancelSubscriptionNow()
    {
        try {
            $shop = auth()->user()->shop;
            auth()->user()->cancelSubscriptionNow();
            $shop->update([
                'status' => 0,
            ]);
            return back()->with('success_msg', 'your shop has been deactivated');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function cancelSubscription()
    {

        try {
            auth()->user()->cancelSubscriptionNow();

            return back()->with('success_msg', 'Subscription has been Canceled');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function resumeSubscription()
    {

        try {

            Stripe::setApiKey(env('STRIPE_SECRET'));
            $product = StripeProduct::create([
                'name' => 'Basic Plan',
            ]);
            $price = Price::create([
                'product' => $product->id,
                'unit_amount' => 2495,
                'currency' => 'usd',
                'recurring' => [
                    'interval' => 'month',
                ],
                'nickname' => 'basic-monthly',
            ]);
            auth()->user()->newSubscription(
                'basic',
                $price->id
            )->create(auth()->user()->getCard()->id);

            return back()->with('success_msg', 'Subscription has been Resumed');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    // public function subscriptionStatus()
    // {


    //     $getSubscription = auth()->user()->getSubscription();
    //     if ($getSubscription->stripe_status !== 'active' || $getSubscription->ends_at !== null) {
    //         $status = false;
    //     } else {
    //         $status = true;
    //     }
    //     return $status;
    // }
}
