<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AppApiController extends Controller
{
    function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json(['token' => $token, 'user' => $user], 200);
            } else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    function user(Request $request)
    {
        return auth('sanctum')->user();
    }

    function checkin(Request $request)
    {
        $ticket = $request->ticket;
        $zone = Zone::find($request->zone_id);
        $ticket = Ticket::where('ticket', $ticket)->with('product')->firstOrFail();
        if ($ticket->active == 0) {
            return response()->json(['error' => __('words.ticket_not_active')]);
        }
        // check if the ticket is valid for the current date
        if (!in_array(now()->format('Y-m-d'), $ticket->dates)) {
            return response()->json(['error' => __('words.to_early_to_scan')], 500);
        }

        // check if the ticket is valid for this zone
        if ($ticket->product->zones->doesntContain($zone)) {
            return response()->json(['error' => __('words.invalid_zone_error')], 500);
        }

        $isCheckedIn = $ticket->scanedBy()
            ->where('action', 'Checked in')
            ->where('zone_id', $zone->id)
            ->exists();

        if ($ticket->product->one_time && $isCheckedIn) {
            return response()->json(['error' => __('words.one_time_usage')], 500);
        }

        $lastScan = $ticket->scanedBy()
            ->whereIn('action', ['Checked in', 'Checked Out'])
            ->where('zone_id', $zone->id)
            ->whereDate('ticket_user.created_at', today())
            ->orderByPivot('created_at', 'desc')
            ->first();

        $isCheckedIn = Str::of($lastScan?->pivot?->action)->lower()->exactly('checked in');

        if ($isCheckedIn) {
            return response()->json(['error' => __('words.ticket_already_scanned_error')], 500);
        }

        $ticket->update([
            'logs' => [
                ...$ticket->logs,
                [
                    'time' => now()->format('Y-m-d H:i:s'),
                    'action' => 'Checked in',
                    'zone' => $zone->name
                ]
            ],
            'check_in_zone' => $zone->id,
            'status' => 1
        ]);

        $ticket->scanedBy()
            ->attach(
                auth()->user(),
                ['action' => 'Checked in', 'zone_id' => $zone->id]
            );

        return response()->json(['message' => __('words.ticket_checked_in'), 'data' => $ticket], 200);
    }


    public function checkOut(Request $request)
    {
        $zone = Zone::find($request->zone_id);
        $ticket = Ticket::with('product')->where('ticket', $request->ticket)
            ->firstOrFail();

        $lastScan = $ticket->scanedBy()
            ->whereIn('action', ['Checked in', 'Checked Out'])
            ->where('zone_id', $zone->id)
            ->whereDate('ticket_user.created_at', today())
            ->orderByPivot('created_at', 'desc')
            ->first();

        $isCheckedOut = Str::of($lastScan?->pivot?->action)->lower()->exactly('checked out');

        if ($isCheckedOut || is_null($lastScan) || !$ticket->product->check_out || $ticket->product->one_time) {
            return response()->json(['error' => __('words.check_out_not_available')], 500);
        }

        $ticket->update([
            'logs' => [
                ...$ticket->logs,
                [
                    'time' => now()->format('Y-m-d H:i:s'),
                    'action' => 'Checked Out',
                    'zone' => $zone->name
                ]
            ],
            'check_out_zone' => $zone->id
        ]);

        $ticket->scanedBy()
            ->attach(
                auth()->user(),
                ['action' => 'Checked Out', 'zone_id' => $zone->id]
            );
        return response()->json(['error' => __('words.ticket_checked_out')], 200);
    }
}
