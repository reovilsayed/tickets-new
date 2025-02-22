<?php

use App\Mail\InviteDownload;
use App\Mail\InviteMail;
use App\Mail\TicketDownload;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Invite;
use App\Models\Ticket;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CheckoutService;
use App\Services\TOCOnlineService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EnterzoneContoller;
use App\Http\Controllers\PdfDownloadController;
use App\Http\Controllers\PosDashboardReport;
use App\Http\Controllers\ZoneScannerController;
use App\Http\Middleware\AgeVerification;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Vemcogroup\SmsApi\SmsApi;

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
    if ($event->status == 0) {
        return "Event Closed";
    }
    $products = [];
    $products['all'] = $invite->products;
    foreach ($event->dates() as $date) {
        $products[$date] = $invite->products->filter(fn($product) => in_array($date, $product->dates));
    }
    return view('pages.event_details', compact('event', 'products', 'is_invite', 'invite'));
})->name('invite.product_details')->excludedMiddleware(AgeVerification::class);
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

        $email = request()->email;
        $phone = request()->contact_number;
        if ($email) {
            // Attempt to find user by email
            $user = User::where('email', $email)->first();

            // If no user is found by email, create with email provided
            if (!$user) {
                $user = User::create([
                    'name' => request()->name,
                    'email' => $email,
                    'contact_number' => $phone,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password2176565'),
                    'country' => 'PT',
                    'role_id' => 2,
                    'vatNumber' => $billing['vatNumber'] ?? null,

                ]);
            }
        } elseif ($phone) {
            // Attempt to find user by phone
            $user = User::where('contact_number', $phone)->first();

            // If no user is found by phone, create with a fake email
            if (!$user) {
                $user = User::create([
                    'name' => request()->name,
                    'email' => 'fake' . uniqid() . '@mail.com',
                    'contact_number' => $phone,
                    'email_verified_at' => now(),
                    'role_id' => 2,
                    'password' => Hash::make('password2176565'),
                    'country' => 'PT',
                    'vatNumber' => $billing['vatNumber'] ?? null,

                ]);
            }
        } else {
            // Handle case when neither phone nor email is provided
            $user = User::create([
                'name' => request()->name ?? 'fake user',
                'email' => 'fake' . uniqid() . '@mail.com',
                'contact_number' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password2176565'),
                'country' => 'PT',
                'role_id' => 2,
                'vatNumber' => $billing['vatNumber'] ?? null,

            ]);
        }


        DB::commit();
        $order = CheckoutService::create($event, $request, isFree: true, invite: $invite, user: $user);



        return redirect()->back()->with('success_msg', 'ThankYou For Your Claim');
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors($e->getMessage());
    } catch (Error $e) {
        DB::rollBack();
        return redirect()->back()->withErrors($e->getMessage());
    }
})->name('invite.checkout')->excludedMiddleware(AgeVerification::class);
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
    Log::info('payment request: ' . json_encode($request->all()));
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
                        $product->quantity = $product->quantity - count($data);
                        $product->save();
                    }
                }

                $coupon = Coupon::where('code', $order->discount_code)->first();
                if ($coupon) {
                    $coupon->increment('used', $new_order->tickets()->count());
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

    // Normalize the extras array to ensure consistent structure
    $normalizedExtras = [];
    foreach ($extras as $key => $extra) {
        if (is_array($extra) && isset($extra['id'])) {
            $normalizedExtras[$extra['id']] = $extra;
        } elseif (is_object($extra) && isset($extra->id)) {
            $normalizedExtras[$extra->id] = (array) $extra;
        }
    }

    foreach ($request->withdraw as $key => $qty) {
        if ($qty && isset($normalizedExtras[$key])) {
            $normalizedExtras[$key]['used'] += $qty;

            $log['action'] = 'Withdrawn ' . $qty . ' quantity of ' . $normalizedExtras[$key]['name'];
        }
    }

    $data = $ticket->logs;
    array_push($data, $log);
    $ticket->extras = $normalizedExtras;
    $ticket->logs = $data;
    $ticket->scanedBy()->attach(auth()->id(), ['action' => $log['action'], 'zone_id' => $zone->id]);
    $ticket->save();

    return redirect()->back()->with('success_msg', __('words.extra_product_withdraw_success_message'));
})->name('extras-used');

Route::group(['prefix' => 'zone', 'as' => 'zone.', 'middleware' => ['auth', 'role:staffzone']], function () {
    Route::get('/', [EnterzoneContoller::class, 'enterForm'])->name('enter');
    Route::post('/enter', [EnterzoneContoller::class, 'enter'])->name('enter.post');
    Route::get('/scanner', [EnterzoneContoller::class, 'scanner'])->name('scanner');
    Route::get('{zone}/{ticket}/checkin', [ZoneScannerController::class, 'checkIn'])->name('checkin');
    Route::get('{zone}/{ticket}/checkout', [ZoneScannerController::class, 'checkOut'])->name('checkout');
});
Route::group(['prefix' => 'food-zone', 'as' => 'extraszone.', 'middleware' => ['auth', 'role:staffzone']], function () {
    Route::get('/', [EnterzoneContoller::class, 'enterExtraForm'])->name('enter');
    Route::post('/enter', [EnterzoneContoller::class, 'enterExtra'])->name('enter.post');
    Route::get('/scanner', [EnterzoneContoller::class, 'scannerExtra'])->name('scanner');
})->middleware(['auth', 'role:staffzone']);

Route::middleware(['auth', 'role:pos'])->group(function () {
    Route::get('/pos', function () {
        return view('pos');
    });
    Route::post('api/create-order', [ApiController::class, 'createOrder']);
    Route::post('api/update-ticket', [ApiController::class, 'updateTicket']);
    Route::post('api/paid-ticket/update', [ApiController::class, 'paidTicketStatusUpdate']);
    Route::get('/pos/{order}/mark', [PosDashboardReport::class, 'index'])->name('order.marked');
    Route::put('/pos/{order}/update', [PosDashboardReport::class, 'update'])->name('order.update');
    Route::put('/pos/{order}/email', [PosDashboardReport::class, 'email'])->name('order.email');
    Route::put('/pos/{order}/sms', [PosDashboardReport::class, 'sms'])->name('order.sms');
    Route::get('/pos/reports', PosDashboardReport::class);
    Route::get('/pos/{page}', function () {
        return view('pos');
    });

    Route::prefix('api')->group(function () {
        Route::get('/tickets', [ApiController::class, 'index']);
        Route::get('/events', [ApiController::class, 'events']);
        Route::get('/extras', [ApiController::class, 'extras']);
        Route::get('/event-extras/{event}', [ApiController::class, 'eventExtras']);
    });
});
Route::get('aaspi/extrasasd', [ApiController::class, 'extras']);

Route::get('/my-wallet/{user:uniqid}', function (User $user, Request $request) {
    // Fetch the events where the wallet is 1, ordered by latest
    $events = Event::where('wallet', 1)->orderBy('sequence', 'asc')->get();
    if ($events->count() == 0) {
        return "No event found";
    }

    // Determine the current event based on the request or default to the first event
    $event = $request->filled('event_id')
        ? Event::find($request->event_id)
        : $events->first() ?? new Event();

    // Fetch the user's orders excluding those with 'invite' as the payment method
    $orders = Order::where('user_id', $user->id)->where('event_id', $event->id)
        ->where('payment_method', '!=', 'invite')
        ->where('payment_status', 1)
        ->latest()
        ->get();

    // Fetch the user's tickets for the selected event and with a non-null order ID
    $tickets = $user->tickets()
        ->where('event_id', $event->id)
        ->whereNotNull('order_id')
        ->get();

    return view('pages.digitalWalletNew', compact('user', 'orders', 'events', 'event', 'tickets'));
})->name('digital-wallet');



Route::get('/toc-online-test/{order}', function ( $order) {
    $order = Order::with('tickets')->where('id',$order )->first();
    $toco = new TOCOnlineService;
    $response = $toco->createCommercialSalesDocument($order);
    if (isset($response['id']) ) {
        Log::info($response);
        $order->invoice_id = $response['id'];
        $order->invoice_url = $response['public_link'];
        $order->invoice_body = json_encode($response);
        $order->save();
        $response = $toco->sendEmailDocument($order, $response['id']);
        Log::info($response);
        return back()->with([
            'message'    => "Invoice Created",
            'alert-type' => 'success',
        ]);
    }else{
        return $response;
    }

})->name('toc-online-test');



Route::get('/api/user/pos-permission', [ApiController::class, 'getPosPermissions'])->middleware('auth');
