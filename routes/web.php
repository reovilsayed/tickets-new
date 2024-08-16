<?php

use App\Charts\EventTicketSellChart;
use App\Charts\OrderSalesByTicketChart;
use App\Charts\OrderSalesChart;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\EnterzoneContoller;
use App\Http\Controllers\EventAnalyticsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WishlistController;
use App\Mail\TicketDownload;
use App\Mail\TicketPlaced;
use App\Models\Event;
use App\Models\Extra;
use App\Models\Extras;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use App\Services\EventReport;
use App\Services\TOCOnlineService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;;

use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use Illuminate\Support\Str;
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
    Route::get('/products/{product}/duplicate', function (Product $product) {
        $newTicket = $product->replicate();
        $newTicket->save();
        return redirect()->back();
    })->name('voyager.products.duplicate');

    Route::get('/products/{product}/extras', function (Product $product) {

        $extras = Extra::where('event_id', $product->event_id)->get();

        return view('vendor.voyager.products.extras', compact('extras', 'product'));
    })->name('voyager.products.extras');

    Route::post('/products/{product}/add-extras', function (Product $product, Request $request) {

        $data = [];
        foreach ($request->extras as $key => $extra) {

            if (isset($extra['checked'])) {
                $data[$key] = $extra['qty'];
            }
        }
        $product->extras = $data;
        $product->save();
        return redirect()->back()->with(['alert-type' => 'success', 'message' => 'Extras updated']);
    })->name('voyager.products.add-extras');
    Route::get('/send/email/{order}', function (Order $order, Request $request) {

        // try {
        $ticket = null;
        $product = null;
        if ($request->filled('ticket')) {
            $ticket = Ticket::find($request->ticket);
        }
        if ($request->filled('product')) {
            $product = Product::find($request->product);
        }
        if ($product && $ticket) {
            Mail::to($order->user->email)->send(new TicketDownload($order, $product, $ticket));
        } else {
            $products = $order->tickets->groupBy('product_id');

            foreach ($products as $key => $tickets) {
                $product = Product::find($key);

                Mail::to($order->user->email)->send(new TicketDownload($order, $product, $ticket));
            }
        }
        return redirect()->back()->with([
            'message' => 'Email sent successfully',
            'alert-type' => 'success',
        ]);
        // } catch (Exception $e) {
        //     return redirect()->back()->with([
        //         'message' => 'Email sent failed',
        //         'alert-type' => 'error',
        //     ]);
        // }
    })->name('send.email');
    Route::group(['prefix' => '/events/{event}/analytics'], function () {
        Route::get('/', [EventAnalyticsController::class, 'index'])->name('voyager.events.analytics');
        Route::get('/ticket-participants-report', [EventAnalyticsController::class, 'ticketParticipanReport'])->name('voyager.events.ticketParticipanReport.analytics');
        Route::get('/sales-report', [EventAnalyticsController::class, 'salesReport'])->name('voyager.events.salesReport.analytics');
        Route::get('/customer-report', [EventAnalyticsController::class, 'customerReport'])->name('voyager.events.customer.analytics');
        Route::get('/customer-report/{user}/orders', [EventAnalyticsController::class, 'customerReportOrders'])->name('voyager.events.customer.analytics.orders');
        Route::get('/customer-report/{user}/tickets', [EventAnalyticsController::class, 'customerReportTickets'])->name('voyager.events.customer.analytics.tickets');
    });
    Route::get('orders/refund/{order}', [EventAnalyticsController::class, 'refund'])->name('order.refund');
});
Auth::routes(['verify' => true]);

Route::get('page/{slug}', [PageController::class, 'getPage']);


Route::get('t/{order:security_key}', function (Request $request, Order $order) {
    $tickets = $order->tickets;

    if ($request->filled('p')) {
        $tickets = $order->tickets()->where('product_id', $request->p)->get();
    }
    if ($request->filled('t')) {

        $tickets = $order->tickets()->where('ticket', $request->t)->get();
    }
    if (!$tickets->count()) abort(403, 'No tickets found');
    return view('ticketpdf', compact('tickets'));
})->name('download.ticket');



Route::post('payment-callback/{type}', function ($type, Request $request) {
    Log::info($request->all());
    if ($type == 'generic') {
        $order = Order::where('transaction_id', $request->key)->where('payment_status', 0)->first();
        if ($order) {
            if ($request->status == 'success') {
                $order->status = 1;
                $order->payment_status = 1;
                $order->date_paid = now();
                $order->save();

                $new_order = Order::where('transaction_id', $request->key)->first();
                $products = $new_order->tickets->groupBy('product_id');
                foreach ($products as $key => $tickets) {
                    $product = Product::find($key);
                    Mail::to($order->user->email)->send(new TicketDownload($order, $product, null));
                }
                // $toco = new TOCOnlineService;
                // $response = $toco->createCommercialSalesDocument($order);
                // Log::info($response);
                // $new_order->invoice_id = $response['id'];
                // $new_order->invoice_url = $response['public_link'];
                // $new_order->invoice_body = json_encode($response);
                $new_order->save();
                // $response = $toco->sendEmailDocument($order, $response['id']);
                // Log::info($response);
            } else {
                $order->status = 2;
                $order->payment_status = 2;
                $order->save();
            }
        }
    }
    if ($type == 'payment') {

        $order = Order::where('transaction_id', $request->key)->where('payment_status', 0)->first();
        if ($order) {
            $order->currency = $request->currency;
            $order->payment_method_title = $request->method;
            $order->save();
        }
    }
});



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('event/{event:slug}/checkout', [PageController::class, 'checkout'])->name('checkout');
    Route::post('event/{event:slug}/store-checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});

Route::post('age-verification', function (Request $request) {

    $cookie = cookie('age-verification', $request->verify ? 'true' : 'false', 24 * 60);
    return redirect()->back()->withCookie($cookie);
})->name('verify.age');


Route::post('extras-used', function (Request $request) {

    $request->validate([
        'ticket' => 'required',
        'withdraw' => 'required',
        'session' => 'required',
    ]);
    if (session()->get('enter-extra-zone')['id'] != $request->session) throw new Exception(__('Unauthorized access'));
    $ticket = Ticket::where('ticket', $request->ticket)->first();
    $extras = $ticket->extras;
    $zone = session()->get('enter-extra-zone')['zone'];
    $log = ['time' => now()->format('Y-m-d H:i:s'), 'action' => '', 'zone' => $zone->name];
    
    foreach ($request->withdraw as $key => $qty) {
        if($qty){
            $extras[$key]['used'] += $qty;
            
            $log['action'] = 'Withdrawn ' . $qty . ' quantity of ' . $extras[$key]['name'];
        }
    };
    $data = $ticket->logs;
    array_push($data, $log);
    $ticket->extras = $extras;
    $ticket->logs = $data;
    $ticket->save();
    return redirect()->back()->with('success_msg', __('extra_product_withdraw_success_message'));
})->name('extras-used');

Route::group(['prefix' => 'zone', 'as' => 'zone.'], function () {
    Route::get('/', [EnterzoneContoller::class, 'enterForm'])->name('enter');
    Route::post('/enter', [EnterzoneContoller::class, 'enter'])->name('enter.post');
    Route::get('/scanner', [EnterzoneContoller::class, 'scanner'])->name('scanner');
});
Route::group(['prefix' => 'food-zone', 'as' => 'extraszone.'], function () {
    Route::get('/', [EnterzoneContoller::class, 'enterExtraForm'])->name('enter');
    Route::post('/enter', [EnterzoneContoller::class, 'enterExtra'])->name('enter.post');
    Route::get('/scanner', [EnterzoneContoller::class, 'scannerExtra'])->name('scanner');
});
