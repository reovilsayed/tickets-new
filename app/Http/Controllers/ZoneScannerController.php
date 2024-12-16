<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Zone;

class ZoneScannerController extends Controller
{
    public function checkIn(Zone $zone, Ticket $ticket)
    {
        try {

            if (!in_array(now()->format('Y-m-d'), $ticket->product->dates)) {
                return redirect()->back()->withError(__('words.to_early_to_scan'));
            }

            if (!$ticket->product->zones->contains($zone)) {
                return redirect()->back()->withError(__('words.invalid_zone_error'));
            }

            // Check if the ticket has already been scanned

            if ($ticket->product->one_time && $ticket->status === 1) {
                return redirect()->back()->withError(__('words.one_time_usage'));
            }

            if (
                $ticket->scanedBy()->where('action', 'Checked in')->orWhere('action', 'Checked Out')->count() !=
                $ticket->scanedBy()->where('action', 'Checked in')->orWhere('action', 'Checked Out')
                ->wherePivotBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->count() > 0
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
    }

    public function checkOut(Zone $zone, Ticket $ticket)
    {
        return 'checkout';
    }
}
