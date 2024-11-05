<?php

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
use App\Http\Middleware\AgeVerification;
use App\Models\Event;
use App\Models\User;
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
                    'name' => $billing['name'] ?? 'fake user',
                    'email' => $email,
                    'contact_number' => $phone,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password2176565'),
                    'country' => 'PT',
                    'role_id' => 2,
                    'vatNumber' => $billing['vatNumber'] ?? null,
                    'uniqid' => uniqid()
                ]);
            }
        } elseif ($phone) {
            // Attempt to find user by phone
            $user = User::where('contact_number', $phone)->first();

            // If no user is found by phone, create with a fake email
            if (!$user) {
                $user = User::create([
                    'name' => $billing['name'] ?? 'fake user',
                    'email' => 'fake' . uniqid() . '@mail.com',
                    'contact_number' => $phone,
                    'email_verified_at' => now(),
                    'role_id' => 2,
                    'password' => Hash::make('password2176565'),
                    'country' => 'PT',
                    'vatNumber' => $billing['vatNumber'] ?? null,
                    // 'uniqid' => uniqid()
                ]);
            }
        } else {
            // Handle case when neither phone nor email is provided
            $user = User::create([
                'name' => $billing['name'] ?? 'fake user',
                'email' => 'fake' . uniqid() . '@mail.com',
                'contact_number' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password2176565'),
                'country' => 'PT',
                'role_id' => 2,
                'vatNumber' => $billing['vatNumber'] ?? null,
                'uniqid' => uniqid()
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

Route::middleware(['auth', 'role:pos'])->group(function () {
    Route::get('/pos', function () {
        return view('pos');
    });
    Route::post('api/create-order', [ApiController::class, 'createOrder']);
    Route::post('api/update-ticket', [ApiController::class, 'updateTicket']);

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


Route::get('/my-wallet/{user:uniqid}', function (User $user, Request $request) {

    $events = Event::where('status', 1)->latest()->get();

    if ($request->filled('event_id')) {
        $event = Event::where('id', $request->event_id)->first();
    } else {
        $event = @$events[0] ?? null;
    }



    $orders = $user->orders()->where('event_id', $event->id)->where('payment_method', '!=', 'invite')->get();



    $tickets = $user->tickets()->where('event_id', $event->id)->where('order_id', '!=', null)->get();





    return view('pages.digitalWalletNew', compact('user', 'orders', 'events', 'event', 'tickets'));
})->name('digital-wallet');



Route::get('/payment-confirm', function () {
    $order = Order::latest()->first();
    $order->payment_status = true;
    $order->status = 1;
    $products = $order->tickets->groupBy('product_id');

    foreach ($products as $id => $data) {
        $product = Product::find($id);
        if ($product) {
            $product->quantity =  $product->quantity - count($data);
            $product->save();
        }
    }
    $order->save();
});

Route::get('test', function () {
    $users = User::all();
    foreach ($users as $user) {
        $user->update(
            [
                'uniqid' => strtolower((string) Str::ulid())
            ]
        );
    }
});
// Route::get('send',function(){
//     $order = Order::where('payment_status',1)->first();
//     $message = 'Acesso e fatura para o evento: [%goto:' . route('digital-wallet', $order) . '%] !!';
//     SmsApi::send('+351915240193',  $message);
// });
