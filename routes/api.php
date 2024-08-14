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
            if($ticket->product->zones->contains($zone) == false) {
                throw new Exception('Invalid zone');
            };
            if (!$zone) throw new Exception('Zone does not exist');
            $log = ['time' => now()->format('Y-m-d H:i:s'), 'action' => '', 'zone' => ''];
            if ($ticket) {
                if ($ticket->status == 0) {
                    $ticket->status = 1;
                    $ticket->check_in_zone = $zone->id;
                    $log['action'] = 'Checked in';
                } elseif ($ticket->status == 1)
                    if ($ticket->product->check_out) {
                        $ticket->status = 2;
                        $ticket->check_out_zone = $zone->id;
                        $log['action'] = 'Checked Out';
                    } else {
                        throw new Exception('Checkout not allowed');
                    }
                elseif ($ticket->status == 2) {
                    $ticket->status = 1;
                    $ticket->check_in_zone = $zone->id;
                    $log['action'] = 'Checked in';
                } else {
                    throw new Exception('Ticket is expired');
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
                throw new Exception('Ticket not found');
            }
        } else {
            throw new Exception('Authorization failed');
        }
    } catch (Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
})->name('api.scan-ticket');
