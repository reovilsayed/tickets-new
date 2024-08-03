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
use App\Mail\TicketDownload;
use App\Mail\TicketPlaced;
use App\Mail\VerifyEmail;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TOCOnlineService;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;;

use TCG\Voyager\Facades\Voyager;
use KaziRayhan\VivaWallet\Enums\RequestLang;
use KaziRayhan\VivaWallet\Enums\PaymentMethod;
use KaziRayhan\VivaWallet\Facades\VivaWallet;
use KaziRayhan\VivaWallet\Customer;
use KaziRayhan\VivaWallet\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
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

Route::post('/add-address', [CheckoutController::class, 'userAddress'])->name('user.address.store');


Route::get('/', [PageController::class, 'home'])->name('homepage');
Route::get('event/{event:slug}', [PageController::class, 'event_details'])->name('product_details');
Route::get('checkout', [PageController::class, 'checkout'])->name('checkout')->middleware('auth');
Route::post('store-checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');
Route::get('toconline/callback', [PageController::class, 'toconlineCallback']);

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact-store', [PageController::class, 'contactStore'])->name('contact.store');
Route::get('/shops', [PageController::class, 'shops'])->name('shops');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');

Route::get('event/{event:slug}/checkout', [PageController::class, 'checkout'])->name('checkout')->middleware('auth');
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





// Wishlist 
Route::get('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::get('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('wishlist-to-cart/{product_id}', [WishlistController::class, 'wishlistToCart'])->name('wishlistToCart');

//cart
Route::post('event/{event:slug}/add-cart', [CartController::class, 'add'])->name('cart.store');
Route::post('/buynow', [CartController::class, 'buynow'])->name('cart.boynow');
Route::post('/add-update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart-destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart-qty', [CartController::class, 'cartQty'])->name('cart.qty');




//coupon routes
Route::post('/add-coupon', [CouponController::class, 'add'])->name('coupon');
Route::get('/delete-coupon', [CouponController::class, 'destroy'])->name('coupon.destroy');

//checkout routes
Route::post('event/{event:slug}/store-checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');

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


Route::post('setting/bankInfo/update', [SellerPagesController::class, 'bankInfoUpdate'])->middleware('auth',)->name('vendor.bankInfo.update');
Route::post('setting/generalInfo/update', [SellerPagesController::class, 'generalInfoUpdate'])->name('vendor.generalInfo.update');
Route::post('setting/shopAddress/update', [SellerPagesController::class, 'shopAddressUpdate'])->middleware('auth',)->name('vendor.shopAddress.update');
Route::post('/shop/socialLink/store', [SellerPagesController::class, 'shopSocialLinksStore'])->name('vendor.shopSocialLinksStore.store')->middleware('auth');
Route::get('/send-mail', [TicketsController::class, 'mailTicket'])->name('mailTicket');


Route::get('/ticket_pdf', function () {
})->name('ticket_pdf');

// Route::get('/download-ticket', function (Request $request) {
//     $order = Order::find($request->order);
//     $product = Product::find($request->product);
//     $tickets = $order->tickets()->where('product_id', $request->product)->get();


//     Browsershot::url('https://example.com')->save($pathToImage);

//     $name = '#' . $order->id . '_' . str_replace(' ', '_', strtolower($product->name)) . '_for_' . str_replace(' ', '_', strtolower($product->event->name)) . '_' . now()->timestamp . '.pdf';

//     // Browsershot::html('Foo')
//     //         ->setNodeBinary('~/nodevenv/home/sohojear/tickets-new/18/bin/node')
//     //         ->setNpmBinary('~/nodevenv/home/sohojear/tickets-new/18/bin/npm');

// })->name('download.ticket');



Route::get('download-ticket', function (Request $request) {
    $order = Order::find($request->order);
    $product = Product::find($request->product);
    $tickets = $order->tickets()->where('product_id', $request->product)->get();

    return view('ticketpdf', compact('tickets'));
})->name('download.ticket');
Route::get('send-toco', function () {
    $order = Order::latest()->first();
    $toco = new TOCOnlineService;
    //dd($toco->getAccessTokenFromRefreshToken());
    dd($toco->createCommercialSalesDocument($order));
});
Route::post('payment-callback/{type}', function ($type, Request $request) {
    Log::info($request->all());
    if ($type == 'generic') {
        $order = Order::where('transaction_id', $request->key)->firstOrFail();

        if ($request->status == 'success') {
            $order->payment_status = 1;

            $products = $order->tickets->groupBy('product_id');
            foreach ($products as $key => $tickets) {
                $product = Product::find($key);
                Mail::to($order->user->email)->send(new TicketDownload($order, $product));
            }
        } else {
            $order->payment_status = 2;
        }
        $order->save();
    }
    if ($type == 'payment') {
        $order = Order::where('transaction_id', $request->key)->firstOrFail();
        $order->currency = $request->currency;
        $order->payment_method_title = $request->method;
        $order->save();
    }
});
