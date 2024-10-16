<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Extras;
use App\Models\Invite;
use App\Models\Ticket;
use App\Models\Product;
use App\Mail\InviteDownload;
use App\Mail\TicketDownload;
use Illuminate\Http\Request;
use App\Exports\CustomerExport;
use TCG\Voyager\Facades\Voyager;
use App\Services\CheckoutService;
use App\Services\TOCOnlineService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyPosUser;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EnterzoneContoller;
use App\Http\Controllers\MassEmailController;
use App\Http\Controllers\MassInviteController;
use App\Http\Controllers\AdminCustomController;
use App\Http\Controllers\PdfDownloadController;
use App\Http\Controllers\EventAnalyticsController;
use App\Http\Controllers\ExportController;
use App\Mail\InviteMail;

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
Route::get('/invite/{invite:slug}', function (Invite $invite, Request $request) {
    $request->validate([
        'security' => 'required',
    ]);
    if ($invite->security_key != $request->security) {
        abort(403);
    }

    $is_invite = true;
    $event = $invite->event;
    $products = [];
    $products['all'] = $invite->products;
    foreach ($event->dates() as $date) {
        $products[$date] = $invite->products->filter(fn($product) => in_array($date, $product->dates));
    }
    return view('pages.event_details', compact('event', 'products', 'is_invite', 'invite'));
})->name('invite.product_details');
Route::post('invite/{invite:slug}/checkout', function (Invite $invite, Request $request) {
    try {

        $total = 0;
        foreach ($request->tickets as $ticket) {
            $total += $ticket;
        }
        if ($total <= 0) {
            throw new Exception(__('words.nothing_to_order'));
        }
        if ($invite->security_key != $request->security) {
            abort(403);
        }

        $event = $invite->event;
        DB::beginTransaction();
        $order = CheckoutService::create($event, $request, isFree: true, invite: $invite);
        DB::commit();

        $products = $order->tickets->groupBy('product_id');
        foreach ($products as $key => $tickets) {
            $product = Product::find($key);
            Mail::to(request()->email)->send(new InviteDownload($order, $product, null));
        }

        return redirect()->back()->with('success_msg', 'ThankYou For Your Claim');
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors($e->getMessage());
    } catch (Error $e) {
        DB::rollBack();
        return redirect()->back()->withErrors($e->getMessage());
    }
})->name('invite.checkout');
Route::get('toconline/callback', [PageController::class, 'toconlineCallback']);

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact-store', [PageController::class, 'contactStore'])->name('contact.store');

Route::get('/thankyou', [PageController::class, 'thankyou'])->name('thankyou');

//cart
Route::post('event/{event:slug}/add-cart', [CartController::class, 'add'])->name('cart.store');

//coupon routes
Route::post('/event/{event:slug}/add-coupon', [CouponController::class, 'add'])->name('coupon');
Route::get('/delete-coupon', [CouponController::class, 'destroy'])->name('coupon.destroy');

// Route::get('/seller', [SellerPagesController::class, 'dashboard'])->middleware('role:vendor')->name('dashboard');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('customer/export', function () {
        $users = User::all()->map(fn($user) => [
            'first_name' => $user->name,
            'last_name' => $user->l_name,
            'email' => $user->email,
            'contactNumber' => $user->contact_number,
            'vatNumber' => $user->vatNumber,
            'events' => $user->events->unique()->pluck('name')->implode(', '),
        ]);

        return Excel::download(new CustomerExport($users), 'customer_' . now()->format('dmyhi') . '.xlsx');
    })->name('voyager.customer.export');
    Route::get('/products/{product}/duplicate', [AdminCustomController::class, 'duplicateProduct'])->name('voyager.products.duplicate');
    Route::get('/users/{user}/staff', function (User $user) {
        $logs = $user->scans->groupBy('ticket')->map(function ($ticket) {
            return $ticket->map(fn($data) => ['log' => $data->pivot->action . ' at ' . $data->created_at->format('Y-m-d')]);
        });

        $products = $user->scans->groupBy(function ($ticket) {
            return $ticket->product->name;
        })->map(fn($products) => $products->count())->toArray();
        $zones = $user->zones->groupBy(function ($zone) {
            return $zone->name;
        })->map(fn($products) => $products->count())->toArray();
        $data = array_merge($products, $zones);

        return view('vendor.voyager.user.staff', compact('user', 'logs', 'data'));
    })->name('voyager.users.staff');



    Route::get('/products/{product}/create-physical', [AdminCustomController::class, 'ticketCreatePhysical'])->name('voyager.products.ticketCreatePhysical');
    Route::post('/products/{product}/create-physical', [AdminCustomController::class, 'ticketCreatePhysicalPost'])->name('voyager.products.ticketCreatePhysical.post');
    Route::get('/products/{product}/download-physical', [AdminCustomController::class, 'ticketCreatePhysicalDownload'])->name('voyager.products.ticketCreatePhysical.download');
    Route::get('/products/{product}/destroy-physical', [AdminCustomController::class, 'ticketCreatePhysicalDestroy'])->name('voyager.products.ticketCreatePhysical.destroy');
    Route::get('/products/{product}/invite', [AdminCustomController::class, 'personalInviteForm'])->name('voyager.products.invite');
    Route::post('/products/{product}/invite', [AdminCustomController::class, 'personalInvitePost'])->name('voyager.products.invite.post');

    Route::get('/invites/{invite}/add-product', [AdminCustomController::class, 'inviteAddProduct'])->name('voyager.invites.add-product');

    Route::post('/invites/{invite}/store-product', [AdminCustomController::class, 'inviteAddProductStore'])->name('voyager.invites.store-product');
    // mass invite route
    Route::get('bulk/invites', [MassInviteController::class, 'MassInvitePage'])->name('massInvitePage');
    Route::get('bulk/personal-invites-form', [MassInviteController::class, 'MassPersonalInvitePage'])->name('MassPersonalInvitePage');
    Route::get('bulk/invites/get-products/{eventId}', [MassInviteController::class, 'getProducts'])->name('ajax.getProduct');
    Route::post('bulk/invites',[MassInviteController::class,'MassInvite'])->name('MassInvite');
    Route::post('bulk/persona-invites',[MassInviteController::class,'PersonalMassInvite'])->name('PersonalMassInvite');
    Route::get('/export-invites', [ExportController::class, 'exportInvites'])->name('Invite_export');

    Route::get('/products/{product}/extras', [AdminCustomController::class, 'productAddExtras'])->name('voyager.products.extras');
    Route::get('/ticket/{ticket:ticket}/extras', [AdminCustomController::class, 'ticketAddExtras'])->name('voyager.ticket.extras');

    Route::post('/products/{product}/add-extras', [AdminCustomController::class, 'productAddExtrasStore'])->name('voyager.products.add-extras');
    Route::post('/ticket/{ticket:ticket}/add-extras', [AdminCustomController::class, 'ticketAddExtrasStore'])->name('voyager.ticket.add-extras');
    Route::get('/send/email/{order}', [AdminCustomController::class, 'sendEmailOrder'])->name('send.email');
    Route::group(['prefix' => '/events/{event}/analytics'], function () {
        Route::get('/', [EventAnalyticsController::class, 'index'])->name('voyager.events.analytics');
        Route::get('/ticket-participants-report', [EventAnalyticsController::class, 'ticketParticipanReport'])->name('voyager.events.ticketParticipanReport.analytics');
        Route::get('/sales-report', [EventAnalyticsController::class, 'salesReport'])->name('voyager.events.salesReport.analytics');
        Route::get('/checkin', [EventAnalyticsController::class, 'checkinReport'])->name('voyager.events.checkinReport.analytics');
        Route::get('/customer-report', [EventAnalyticsController::class, 'customerReport'])->name('voyager.events.customer.analytics');
        Route::get('/invites-report', [EventAnalyticsController::class, 'invitesReport'])->name('voyager.events.invites.analytics');
        Route::get('/customer-report/{user}/orders', [EventAnalyticsController::class, 'customerReportOrders'])->name('voyager.events.customer.analytics.orders');
        Route::get('/invite-report/orders', [EventAnalyticsController::class, 'inviteReportOrders'])->name('voyager.events.invites.analytics.orders');
        Route::get('/invite-report/tickets', [EventAnalyticsController::class, 'inviteReportTickets'])->name('voyager.events.invites.analytics.tickets');
        Route::get('/customer-report/{user}/tickets', [EventAnalyticsController::class, 'customerReportTickets'])->name('voyager.events.customer.analytics.tickets');
        Route::get('/customer-report/{user}/tickets/access-ticket', [EventAnalyticsController::class, 'giveAccessPage'])->name('voyager.events.customer.analytics.tickets.access-ticket');
        Route::post('/customer-report/{user}/tickets/access-ticket', [EventAnalyticsController::class, 'giveAccessSubmit'])->name('voyager.events.customer.analytics.tickets.access-ticket-submit');
    });
    Route::get('orders/refund/{order}', [AdminCustomController::class, 'refund'])->name('order.refund');
    Route::get('/coupon-generate', [AdminCustomController::class, 'couponGenerate'])->name('voyager.coupon.generate');
    Route::post('/coupon-create', [AdminCustomController::class, 'couponCreate'])->name('voyager.coupon.create');
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
    if (!$tickets->count()) {
        abort(403, 'No tickets found');
    }

    return view('ticketpdf', compact('tickets', 'order'));
})->name('download.ticket');

Route::post('t/{order:security_key}', [PdfDownloadController::class, 'download'])->name('downloadPdf.ticket');

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

                foreach ($products as $id => $data) {
                    $product = Product::find($id);
                    if ($product) {
                        $product->quantity =  $product->quantity - count($data);
                        $product->save();
                    }
                }

                $coupon = Coupon::where('code', $order->discount_code)->first();
                if ($coupon) {
                    $coupon->increment('used', $new_order->tickets()->count());
                }
                foreach ($products as $key => $tickets) {
                    $product = Product::find($key);
                    Mail::to($order->user->email)->send(new TicketDownload($order, $product, null));
                }
                $toco = new TOCOnlineService;
                $response = $toco->createCommercialSalesDocument($order);
                Log::info($response);
                $new_order->invoice_id = $response['id'];
                $new_order->invoice_url = $response['public_link'];
                $new_order->invoice_body = json_encode($response);
                $new_order->save();
                $response = $toco->sendEmailDocument($order, $response['id']);
                Log::info($response);
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
    if (session()->get('enter-extra-zone')['id'] != $request->session) {
        throw new Exception(__('Unauthorized access'));
    }

    $ticket = Ticket::where('ticket', $request->ticket)->first();
    $extras = $ticket->extras;
    $zone = session()->get('enter-extra-zone')['zone'];
    $log = ['time' => now()->format('Y-m-d H:i:s'), 'action' => '', 'zone' => $zone->name];

    foreach ($request->withdraw as $key => $qty) {
        if ($qty) {
            $extras[$key]['used'] += $qty;

            $log['action'] = 'Withdrawn ' . $qty . ' quantity of ' . $extras[$key]['name'];
        }
    };
    $data = $ticket->logs;
    array_push($data, $log);
    $ticket->extras = $extras;
    $ticket->logs = $data;
    $ticket->scanedBy()->attach(auth()->id(), ['action' => $log['action'], 'zone_id' => $zone->id]);
    $ticket->save();
    return redirect()->back()->with('success_msg', __('extra_product_withdraw_success_message'));
})->name('extras-used');

Route::group(['prefix' => 'zone', 'as' => 'zone.', 'middleware' => ['auth', 'role:staffzone']], function () {
    Route::get('/', [EnterzoneContoller::class, 'enterForm'])->name('enter');
    Route::post('/enter', [EnterzoneContoller::class, 'enter'])->name('enter.post');
    Route::get('/scanner', [EnterzoneContoller::class, 'scanner'])->name('scanner');
});
Route::group(['prefix' => 'food-zone', 'as' => 'extraszone.', 'middleware' => ['auth', 'role:staffzone']], function () {
    Route::get('/', [EnterzoneContoller::class, 'enterExtraForm'])->name('enter');
    Route::post('/enter', [EnterzoneContoller::class, 'enterExtra'])->name('enter.post');
    Route::get('/scanner', [EnterzoneContoller::class, 'scannerExtra'])->name('scanner');
})->middleware(['auth', 'role:staffzone']);

Route::middleware(['auth', VerifyPosUser::class])->group(function () {
    Route::get('/pos', function () {
        return view('pos');
    });

    Route::get('/pos/{page}', function () {
        return view('pos');
    });
});

Route::post('api/create-order', [ApiController::class, 'createOrder']);
Route::post('api/update-ticket', [ApiController::class, 'updateTicket']);



