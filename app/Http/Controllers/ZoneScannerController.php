<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Zone;

class ZoneScannerController extends Controller
{
    public function checkIn(Zone $zone, Ticket $ticket)
    {
        // check if the ticket is valid for the current date
        if (!in_array(now()->format('Y-m-d'), $ticket->product->dates)) {
            return redirect()->back()->withError(__('words.to_early_to_scan'));
        }

        // check if the ticket is valid for this zone
        if ($ticket->product->zones->doesntContain($zone)) {
            return redirect()->back()->withError(__('words.invalid_zone_error'));
        }

        $isCheckedIn = $ticket->scanedBy()
            ->where('action', 'Checked in')
            ->where('zone_id', $zone->id)
            ->exists();

        if ($ticket->product->one_time && $isCheckedIn) {
            return redirect()->back()->withError(__('words.one_time_usage'));
        }

        $isCheckedInToday = $ticket->scanedBy()
            ->where('action', 'Checked in')
            ->where('zone_id', $zone->id)
            ->whereDate('ticket_user.created_at', today())
            ->exists();

        if ($isCheckedInToday) {
            return redirect()->back()->withError(__('words.ticket_already_scanned_error'));
        }

        $logs = [
            ...$ticket->logs,
            [
                'time' => now()->format('Y-m-d H:i:s'),
                'action' => 'Checked in',
                'zone' => $zone->name
            ]
        ];

        $ticket->update([
            'logs' => $logs,
            'check_in_zone' => $zone->id
        ]);

        $ticket->scanedBy()
            ->attach(
                auth()->user(),
                ['action' => 'Checked in', 'zone_id' => $zone->id]
            );

        return redirect()->back();
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

        $logs = [
            ...$ticket->logs,
            [
                'time' => now()->format('Y-m-d H:i:s'),
                'action' => 'Checked Out',
                'zone' => $zone->name
            ]
        ];

        $ticket->update([
            'logs' => $logs,
            'check_out_zone' => $zone->id
        ]);

        $ticket->scanedBy()
            ->attach(
                auth()->user(),
                ['action' => 'Checked Out', 'zone_id' => $zone->id]
            );
        return redirect()->back();
    }
}
