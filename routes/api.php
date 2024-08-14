<?php

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
        if (Hash::check(env('SECURITY_KEY'), $request->checksum)) {
            $ticket = Ticket::where('ticket', $request->ticket)->first();
            $zone = Zone::find($request->zone);
            if ($ticket->product->zones->contains($zone) == false) {
                throw new Exception(__('words.invalid_zone'));
            };
            if (!$zone) throw new Exception(__('words.invalid_zone_error'));
            $log = ['time' => now()->format('Y-m-d H:i:s'), 'action' => '', 'zone' => ''];
            if ($ticket) {
                if ($ticket->status == 0) {
                    if ($request->mode != 1) {
                        throw new Exception(__('words.checkout_mode_checkin_error'));
                    }
                    $ticket->status = 1;
                    $ticket->check_in_zone = $zone->id;
                    $log['action'] = 'Checked in';
                } elseif ($ticket->status == 1) {
                    if ($request->mode != 2) {
                        throw new Exception(__('words.checkin_mode_checkout_error'));
                    }
                    if ($ticket->product->check_out) {
                        $ticket->status = 2;
                        $ticket->check_out_zone = $zone->id;
                        $log['action'] = 'Checked Out';
                    } else {
                        throw new Exception(__('words.checkout_not_allowed_error'));
                    }
                } elseif ($ticket->status == 2) {
                    if ($request->mode != 1) {
                        throw new Exception(__('words.checkout_mode_checkin_error'));
                    }
                    $ticket->status = 1;
                    $ticket->check_in_zone = $zone->id;
                    $log['action'] = 'Checked in';
                } else {
                    throw new Exception(__('words.ticket_expired_error'));
                }
                $log['zone'] = $zone->name;
                $data = $ticket->logs;
                array_push($data, $log);
                $ticket->logs = $data;
                $ticket->save();
                return response()->json([
                    'status' => 'success',
                    'message' => $log['action']
                ]);
            } else {
                throw new Exception(__('words.invalid_ticket_error'));
            }
        } else {
            throw new Exception(__('words.illegal_attempt_error'));
        }
    } catch (Exception $e) {
        return response()->json(['status' => 'error', 'message' => __('words.invalid_ticket_error')]);
    }
})->name('api.scan-ticket');
