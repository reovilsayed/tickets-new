<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Zone;

class ZoneScannerController extends Controller
{
    public function checkIn(Zone $zone, $ticket)
    {
        $ticket = Ticket::whereAny(['id', 'ticket'], $ticket)
            ->firstOrFail();

        // check if the ticket is valid for the current date
        if (!in_array(now()->format('Y-m-d'), $ticket->product->dates)) {
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

        $isCheckedInToday = $ticket->scanedBy()
            ->where('action', 'Checked in')
            ->where('zone_id', $zone->id)
            ->whereDate('ticket_user.created_at', today())
            ->exists();

        if (!$ticket->product->check_out && $isCheckedInToday) {
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

    public function checkOut(Zone $zone, Ticket $ticket)
    {
        if (!$ticket->product->check_out || $ticket->product->one_time) {
            return redirect()->back()->withError(__('words.check_out_not_available'));
        }

        $isCheckedInToday = $ticket->scanedBy()
            ->where('action', 'Checked in')
            ->where('zone_id', $zone->id)
            ->whereDate('ticket_user.created_at', today())
            ->exists();

        if (!$isCheckedInToday) {
            return redirect()->back()->withError(__('words.check_out_not_available'));
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
        return redirect()->back();
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
