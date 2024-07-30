<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MassageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PayoutsController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Seller\SellerPagesController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\EmailVerified;
use App\Mail\OfferEmail;
use App\Mail\OrderPlaced;
use App\Mail\TicketPlaced;
use App\Mail\VerifyEmail;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Shop;
use App\Models\Ticket;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;
use TCG\Voyager\Facades\Voyager;
use KaziRayhan\VivaWallet\Enums\RequestLang;
use KaziRayhan\VivaWallet\Enums\PaymentMethod;
use KaziRayhan\VivaWallet\Facades\VivaWallet;
use KaziRayhan\VivaWallet\Customer;
use KaziRayhan\VivaWallet\Payment;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test/{ticket}', function (Ticket $ticket) {
    return new TicketPlaced($ticket, 'This message is for test purpose');
});
// Route::get('/hello', function () {
//     dd(Shop::find(1)->monthlyCharge());
// });
//Vendors


// Route::get('/vendors', [PageController::class, 'vendors'])->name('vendors');


Route::post('follow/{shop}', [PageController::class, 'follow'])->name('follow');
Route::get('liked/shops', [PageController::class, 'followShops'])->name('follow.shops');

Route::post('/add-address', [CheckoutController::class, 'userAddress'])->name('user.address.store');


Route::get('/', [PageController::class, 'home'])->name('homepage');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact-store', [PageController::class, 'contactStore'])->name('contact.store');
Route::get('/shops', [PageController::class, 'shops'])->name('shops');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');

Route::get('/service/{slug}', [PageController::class, 'product_details'])->name('product_details');
Route::get('/checkout', [PageController::class, 'checkout'])->name('checkout')->middleware('auth');
// Route::get('/order_page', [PageController::class, 'order_page'])->name('order_page');
Route::get('/verify-email', [HomeController::class, 'verifyMassage'])->name('verify.massage');
Route::get('/thankyou', [PageController::class, 'thankyou'])->name('thankyou');

Route::post('/subscribe', [PageController::class, 'subscribe'])->name('subscribe');
Route::get('/quickview', [PageController::class, 'quickview'])->name('quickview');
Route::post('/offer/{product}', [HomeController::class, 'offer'])->name('offer');
Route::get('/offer-to-cart', [CartController::class, 'offerToCart'])->name('offer.cart');
Route::get('/set-location', [PageController::class, 'setLocation'])->name('set.location');
Route::get('/location-reset', [PageController::class, 'locationReset'])->name('location.reset');
Route::get('/posts', [PageController::class, 'posts'])->name('posts');
Route::get('/post/{slug}', [PageController::class, 'post'])->name('post');
Route::get('/event-details{slug}', [PageController::class, 'event_details'])->name('product_details');





// Wishlist 
Route::get('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::get('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('wishlist-to-cart/{product_id}', [WishlistController::class, 'wishlistToCart'])->name('wishlistToCart');

//cart
Route::post('/add-cart', [CartController::class, 'add'])->name('cart.store');
Route::post('/buynow', [CartController::class, 'buynow'])->name('cart.boynow');
Route::post('/add-update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart-destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart-qty', [CartController::class, 'cartQty'])->name('cart.qty');




//coupon routes
Route::post('/add-coupon', [CouponController::class, 'add'])->name('coupon');
Route::get('/delete-coupon', [CouponController::class, 'destroy'])->name('coupon.destroy');

//checkout routes
Route::post('/store-checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');

//Rating
Route::post('rating/{product_id}', [PageController::class, 'rating'])->name('rating');
Route::get('/store_front/{slug}', [PageController::class, 'store_front'])->name('store_front');

// Route::get('/seller', [SellerPagesController::class, 'dashboard'])->middleware('role:vendor')->name('dashboard');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Auth::routes();
//  google login
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('google.callback');
// facebook login
Route::get('login/facebook', [LoginController::class, 'redirectToFacebook'])->name('facebook.redirect');
Route::get('login/facebook/callback', [LoginController::class, 'handleFacebookCallback'])->name('facebook.callback');

Route::get('admin/payout/{order}', [PayoutsController::class, 'payouts'])->name('payout')->middleware('auth', 'role:admin');

// Route::get('/vendor-register', [RegisterController::class, 'vendorCreate'])->name('vendor.create');
// Route::get('/vendor-register-2nd-step', [HomeController::class, 'vendorSecondStep'])->name('vendor.second.step');
// Route::post('/2nd-step-store', [HomeController::class, 'vendorSecondStepStore'])->name('vendor.second.step.store');

// Route::get('/shop', [SellerPagesController::class, 'shop'])->name('vendor.shop')->middleware(['auth']);
// Route::post('/store-shop', [SellerPagesController::class, 'shopStore'])->middleware('auth')->name('vendor.store');

// Route::get('/shop/set-up-payment-method', [PaymentsController::class, 'setUpPaymentMethod'])->middleware('auth', 'verifiedEmail', 'second')->name('vendor.setUpPaymentMethod');

Route::get('email/{offer}', function (Offer $offer) {
    return new OfferEmail($offer);
});


Route::get('verify/email', [HomeController::class, 'verifyEmail'])->name('verify.token');
Route::get('/agian/verify/email', [HomeController::class, 'againVerifyEmail'])->name('again.verify.token');

Route::get('page/{slug}', [PageController::class, 'getPage']);

Route::get('/order/seen', [SellerPagesController::class, 'orderSeen'])->name('order.seen');

Route::post('ticket/reply/{ticket}', [TicketsController::class, 'reply'])->name('ticket.reply');
Route::get('ticket/{ticket}', [TicketsController::class, 'show'])->name('ticket.show');
Route::get('ticket/close/{ticket}', [TicketsController::class, 'close'])->name('ticket.close');

Route::get('/vendor/settings', [SellerPagesController::class, 'setting'])->name('vendor.settings');
Route::get('/seen/{notification}', [MassageController::class, 'seen'])->name('massage.seen');
Route::get('/massage/{id?}', [MassageController::class, 'create'])->name('massage.create')->middleware('auth');
Route::get('/massage/store/{id}', [MassageController::class, 'store'])->name('massage.store')->middleware('auth');
Route::post('logo-or-cover/upload', [SellerPagesController::class, 'logoCover'])->middleware('auth')->name('vendor.logo.cover');


Route::post('setting/bankInfo/update', [SellerPagesController::class, 'bankInfoUpdate'])->middleware('auth', )->name('vendor.bankInfo.update');
Route::post('setting/generalInfo/update', [SellerPagesController::class, 'generalInfoUpdate'])->name('vendor.generalInfo.update');
Route::post('setting/shopAddress/update', [SellerPagesController::class, 'shopAddressUpdate'])->middleware('auth', )->name('vendor.shopAddress.update');
Route::post('/shop/socialLink/store', [SellerPagesController::class, 'shopSocialLinksStore'])->name('vendor.shopSocialLinksStore.store')->middleware('auth');


Route::group(['prefix' => 'admin', 'middleware' => 'admin.user'], function () {
    Route::get('/shop/{shop}/active', [HomeController::class, 'shopActive'])->name('admin.shop.active');
    Route::get('/shops/create', [AdminController::class, 'shopCreate'])->name('admin.shop.create');
    Route::post('/shops/store', [AdminController::class, 'shopStore'])->name('admin.shops.store');
    Route::get('/shops', [AdminController::class, 'shopIndex'])->name('admin.shop.index');
    Route::get('/shops/edit/{shop}', [AdminController::class, 'shopEdit'])->name('admin.shops.edit');
    Route::post('/shops/update/{shop}', [AdminController::class, 'shopUpdate'])->name('admin.shops.update');
    Route::post('/shops/delete/{shop}', [AdminController::class, 'shopDelete'])->name('admin.shops.delete');
});



Route::get('test', function () {




    $customer = new Customer(
        $email = 'example@test.com',
        $fullName = 'John Doe',
        $phone = '+306987654321',
        $countryCode = 'GR',
        $requestLang = RequestLang::Greek,
    );


    $payment = new Payment();

    $payment
        ->setAmount(2500)
        ->setCustomerTrns('short description of the items/services being purchased')
        ->setCustomer($customer)
        ->setPaymentTimeout(3600)
        ->setPreauth(false)
        ->setAllowRecurring(true)
        ->setMaxInstallments(3)
        ->setPaymentNotification(true)
        ->setTipAmount(250)
        ->setDisableExactAmount(false)
        ->setDisableCash(true)
        ->setDisableWallet(false)
        ->setSourceCode(4235)
        ->setMerchantTrns('customer order reference number')
        ->setTags(['tag-1', 'tag-2'])
        ->setBrandColor('009688')
        ->setPreselectedPaymentMethod(PaymentMethod::PayPal);

    $checkoutUrl = VivaWallet::createPaymentOrder($payment, $customer);
    return redirect($checkoutUrl);
});


Route::get('/callback/payment/success', function (Request $request) {

    $transactionId = $request->t;
    $transaction = VivaWallet::retrieveTransaction($transactionId);
    $order = Order::where('order_number', $transaction['merchantTrns'])->first();
    if ($order && $transaction['statusId'] == 'F') {
        $order->status = 1;
        $order->save();
        foreach ($order->childrens as $child) {
            $child->status = 1;
            $child->save();
        }
    }
    return redirect()->route('thankyou', $order);
});
Route::get('/callback/payment/failed', function () {
});

