<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WishlistController;
use App\Mail\TicketDownload;
use App\Mail\TicketPlaced;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ticket;
use App\Services\TOCOnlineService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;;

use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

Route::get('toconline/callback', [PageController::class, 'toconlineCallback']);

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact-store', [PageController::class, 'contactStore'])->name('contact.store');
Route::get('/shops', [PageController::class, 'shops'])->name('shops');
Route::get('/cart', [PageController::class, 'cart'])->name('cart');

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


//Rating
Route::post('rating/{product_id}', [PageController::class, 'rating'])->name('rating');
Route::get('/store_front/{slug}', [PageController::class, 'store_front'])->name('store_front');


// Route::get('/seller', [SellerPagesController::class, 'dashboard'])->middleware('role:vendor')->name('dashboard');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Auth::routes(['verify' => true]);

Route::get('page/{slug}', [PageController::class, 'getPage']);

Route::get('download-ticket', function (Request $request) {
    $order = Order::find($request->order);
    $product = Product::find($request->product);
    $tickets = $order->tickets()->where('product_id', $request->product)->get();

    return view('ticketpdf', compact('tickets'));
})->name('download.ticket');

Route::post('payment-callback/{type}', function ($type, Request $request) {
    Log::info($request->all());
    if ($type == 'generic') {
        $order = Order::where('transaction_id', $request->key)->firstOrFail();

        if ($request->status == 'success') {
            $order->payment_status = 1;
            $order->save();

            $products = $order->tickets->groupBy('product_id');
            foreach ($products as $key => $tickets) {
                $product = Product::find($key);
                Mail::to($order->user->email)->send(new TicketDownload($order, $product));
            }
            $toco = new TOCOnlineService;
            $toco->createCommercialSalesDocument($order);
        } else {
            $order->payment_status = 2;
            $order->save();
        }
    }
    if ($type == 'payment') {
        $order = Order::where('transaction_id', $request->key)->firstOrFail();
        $order->currency = $request->currency;
        $order->payment_method_title = $request->method;
        $order->save();
    }
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('event/{event:slug}/checkout', [PageController::class, 'checkout'])->name('checkout');
    Route::post('event/{event:slug}/store-checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});
