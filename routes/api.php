<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AppApiController;
use App\Models\Extra;
use App\Models\Ticket;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/scan-ticket', function (Request $request) {
    try {

        $ticket = Ticket::where('ticket', $request->ticket)->first();

        $zone = Zone::find($request->zone);

        if (in_array(now()->format('Y-m-d'), $ticket->product->dates) == false) throw new Exception(__('words.to_early_to_scan'));
        // request checksum and securiy key dose not match
        if (Hash::check(env('SECURITY_KEY'), $request->checksum) == false)  throw new Exception(__('words.illegal_attempt_error'));
        // ticket is empty
        if (!$ticket)   throw new Exception(__('words.invalid_ticket_error'));
        //  zone is empty or zone is not in ticket 
        if (!$zone || $ticket->product->zones->contains($zone) == false) throw new Exception(__('words.invalid_zone_error'));

        // Check if the ticket has already been scanned
        if (
            $ticket->product->one_time &&
            $ticket->scanedBy()->where('action', 'Checked in')
            ->orWhere('action', 'Checked Out')
            ->count()  != $ticket->scanedBy()->where('action', 'Checked in')
            ->orWhere('action', 'Checked Out')
            ->wherePivotBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->count() > 0
        ) {
            throw new Exception(__('words.ticket_already_scanned_error'));
        }

        $log = ['time' => now()->format('Y-m-d H:i:s'), 'action' => '', 'zone' => ''];


        switch (['Pending', 'Checked in', 'Checked out', 'Expired'][$ticket->status]) {
            case 'Pending':
                //Scaning mode is not check in
                if ($request->mode != 1)   throw new Exception(__('words.checkout_mode_checkin_error'));
                if ($ticket->product->check_in != true) throw new Exception(__('words.check_in_not_available'));
                if ($ticket->scanedBy()->where('action', 'Checked in')->where('zone_id', $zone->id)->wherePivotBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->count() > 0  && $request->mode == 1) {
                    throw new Exception(__('words.check_in_not_available'));
                }
                $ticket->status = 1; // Check in;
                $ticket->check_in_zone = $zone->id;
                $log['action'] = 'Checked in';
                break;
            case 'Checked in':


                // if ($ticket->status = 1 && $request->mode == 1) throw new Exception(__('words.check_in_not_available'));
                if ($ticket->product->check_out != true && $request->mode == 2) throw new Exception(__('words.check_out_not_available'));
                // Check if ticket is already checked in at this zone and mode scaning mode is checkin

                if ($ticket->scanedBy()->where('action', 'Checked in')->where('zone_id', $zone->id)->wherePivotBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->count() > 0  && $request->mode == 1) {
                    if ($ticket->status = 1 && $request->mode == 1) throw new Exception(__('words.check_in_not_available'));
                    // throw new Exception(__('words.check_in_not_available'));
                }
                // if ($ticket->scanedBy()->where('action', 'Checked Out')->where('zone_id', $zone->id)->wherePivotBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->count() > 0  && $request->mode == 2) {
                //     throw new Exception(__('words.check_out_not_available'));
                // }
                if ($request->mode == 1) { //Checkin
                    $ticket->status = 1;
                    $ticket->check_in_zone = $zone->id;
                    $log['action'] = 'Checked in';
                } else { //Checkout
                    $ticket->status = 2;
                    $ticket->check_out_zone = $zone->id;
                    $log['action'] = 'Checked Out';
                }


                break;
            case 'Checked out':
                //Scaning mode is not check in
                if ($request->mode != 1)   throw new Exception(__('words.checkout_mode_checkin_error'));
                if ($ticket->product->check_in != true) throw new Exception(__('words.check_in_not_available1'));
                // if ($ticket->scanedBy()->where('action', 'Checked in')->where('zone_id', $zone->id)->wherePivotBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->count() > 0  && $request->mode == 1) {
                //     throw new Exception(__('words.check_in_not_available'));
                // }
                $ticket->status = 1;
                $ticket->check_out_zone = $zone->id;
                $log['action'] = 'Checked in';
                break;
            default:
                throw new Exception(__('words.ticket_expired_error'));
                break;
        }

        $log['zone'] = $zone->name;
        $data = $ticket->logs;
        array_push($data, $log);
        $ticket->logs = $data;

        $ticket->save();
        $ticket->scanedBy()->attach($request->user, ['action' => $log['action'], 'zone_id' => $zone->id]);
        return response()->json([
            'status' => 'success',
            'data' => [
                'name' => $ticket->product->name,
            ],
            'message' => $log['action']
        ]);
    } catch (Error | Exception $e) {
        return response()->json([
            'status' => 'error',
            'data' => [
                'name' => $ticket->product->name,
            ],
            'message' => $e->getMessage()
        ]);
    }
})->name('api.scan-ticket');

Route::post('/extras-scan-ticker', function (Request $request) {

    $ticket = Ticket::where('ticket', $request->ticket)->where('active', 1)->first();
    if ($ticket) {
        $extras = [];

        foreach ($ticket->extras as $extra) {
            // if (Extra::find($extra['id'])->zone_id != $request->zone) {
            //     continue;
            // }
            array_push($extras, $extra);
        }
        $data = ['status' => 'success', 'extras' => $extras, 'ticket' => $ticket];
        return response()->json($data);
    } else {
        return response()->json(['status' => 'error', 'message' => __('words.invalid_ticket_error')]);
    }
})->name('api.extras-scan-ticket');



Route::post('/tickets/get', [ApiController::class, 'getTicket']);
Route::post('/tickets/update-code', [ApiController::class, 'updateTicketCode']);
Route::post('/tickets/activate', [ApiController::class, 'activateTicket']);
Route::post('/tickets/toggle-active', [ApiController::class, 'toggleTicketActive']);
Route::post('/ticket-extras', [ApiController::class, 'ticketExtras']);


Route::get('/withdraw_checked', function () {
    return response()->json([
        'checked' => setting('admin.withdraw') == "1" ? true : false
    ]);
});

Route::group(['prefix' => 'app'], function () {
    Route::post(('login'), [AppApiController::class, 'login']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('user', [AppApiController::class, 'user']);
        Route::post('checkin', [AppApiController::class, 'checkin']);
        Route::post('checkout', [AppApiController::class, 'checkout']);
        Route::post('extras', [AppApiController::class, 'getExtras']);
        Route::post('withdraw', [AppApiController::class, 'withdrawExtra']);
        Route::post('zone-type', [AppApiController::class, 'getZoneType']);
        Route::get('extras/all', [AppApiController::class, 'getAllExtras']);
        Route::get('extras/categories', [AppApiController::class, 'getExtraCategories']);
        Route::get('orders', [AppApiController::class, 'getOrders']);
        Route::post('order/create', [AppApiController::class, 'createOrder']);
        Route::get('wallet', [AppApiController::class, 'getMyWallet']);
        Route::post('wallet/customer', [AppApiController::class, 'getWalletCustomer']);
        Route::get('/events', [AppApiController::class, 'events']);
    });
    Route::post('user-from-qr', [AppApiController::class, 'getUserFromQr']);
});
