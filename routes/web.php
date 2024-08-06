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


Route::get('/', [PageController::class, 'home'])->name('homepage');
Route::get('event/{event:slug}', [PageController::class, 'event_details'])->name('product_details');

Route::get('toconline/callback', [PageController::class, 'toconlineCallback']);

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact-store', [PageController::class, 'contactStore'])->name('contact.store');

Route::get('/thankyou', [PageController::class, 'thankyou'])->name('thankyou');







//cart
Route::post('event/{event:slug}/add-cart', [CartController::class, 'add'])->name('cart.store');



//coupon routes
Route::post('/add-coupon', [CouponController::class, 'add'])->name('coupon');
Route::get('/delete-coupon', [CouponController::class, 'destroy'])->name('coupon.destroy');




// Route::get('/seller', [SellerPagesController::class, 'dashboard'])->middleware('role:vendor')->name('dashboard');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('/admin/products/{product}/duplicate', function (Product $product) {
        $newTicket = $product->replicate();
        $newTicket->save();
        return redirect()->back();
    })->name('voyager.products.duplicate');
});
Auth::routes(['verify' => true]);

Route::get('page/{slug}', [PageController::class, 'getPage']);
// Route::get('user-invoice/{$order}', [PageController::class, 'invoiceOrder'])->name('invoiceOrder');

Route::get('download-ticket', function (Request $request) {
    $order = Order::find($request->order);
    $product = Product::find($request->product);
    $tickets = $order->tickets()->where('product_id', $request->product)->get();

    return view('ticketpdf', compact('tickets'));
})->name('download.ticket');
Route::get('user-invoice', function (Request $request) {
    $order = Order::find($request->order);
    $product = Product::find($request->product);
    $tickets = $order->tickets()->where('product_id', $request->product)->get();

    return view('invoice', compact('order', 'tickets'));
})->name('invoice.order');

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
            $response = $toco->createCommercialSalesDocument($order);
            $order->invoice_id = $response['id'];
            $order->invoice_url = $response['public_link'];
            $order->invoice_body = json_encode($response);
            $order->save();
            $response = $toco->sendEmailDocument($order);
            
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

