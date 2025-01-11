<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Ticket;
use Illuminate\Support\Str;

class ZoneScannerController extends Controller
{
    public function checkIn(Zone $zone, $ticket)
    {
        $ticket = Ticket::where('ticket', $ticket)
            ->firstOrFail();

        // check if the ticket is valid for the current date
        if (!in_array(now()->format('Y-m-d'), $ticket->dates)) {
            return $this->withResponse(__('words.to_early_to_scan'));
        }

        // check if the ticket is valid for this zone
        if ($ticket->product->zones->doesntContain($zone)) {
            return $this->withResponse(__('words.invalid_zone_error'));
        }

        $isCheckedIn = $ticket->scanedBy()
            ->where('action', 'Checked in')
            ->where('zone_id', $zone->id)
            ->exists();

        if ($ticket->product->one_time && $isCheckedIn) {
            return $this->withResponse(__('words.one_time_usage'));
        }

        $lastScan = $ticket->scanedBy()
            ->whereIn('action', ['Checked in', 'Checked Out'])
            ->where('zone_id', $zone->id)
            ->whereDate('ticket_user.created_at', today())
            ->orderByPivot('created_at', 'desc')
            ->first();

        $isCheckedIn = Str::of($lastScan?->pivot?->action)->lower()->exactly('checked in');

        if ($isCheckedIn) {
            return $this->withResponse(__('words.ticket_already_scanned_error'));
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
            'check_in_zone' => $zone->id
        ]);

        $ticket->scanedBy()
            ->attach(
                auth()->user(),
                ['action' => 'Checked in', 'zone_id' => $zone->id]
            );

        return $this->withResponse(__('words.ticket_checked_in'), 'success');
    }

    public function checkOut(Zone $zone, $ticket)
    {
        $ticket = Ticket::where('ticket', $ticket)
            ->firstOrFail();

        $lastScan = $ticket->scanedBy()
            ->whereIn('action', ['Checked in', 'Checked Out'])
            ->where('zone_id', $zone->id)
            ->whereDate('ticket_user.created_at', today())
            ->orderByPivot('created_at', 'desc')
            ->first();

        $isCheckedOut = Str::of($lastScan?->pivot?->action)->lower()->exactly('checked out');

        if ($isCheckedOut || is_null($lastScan) || !$ticket->product->check_out || $ticket->product->one_time) {
            return $this->withResponse(__('words.check_out_not_available'));
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
        return $this->withResponse(__('words.ticket_checked_out'), 'success');
    }

    private function withResponse(string $msg, $mode = 'error')
    {
        if (request()->wantsJson()) {

            return response()->json([
                'msg' => __($msg),
                'hasError' => $mode === 'error',
            ]);
        }

        return redirect()->back()->with($mode, __($msg));
    }
}
