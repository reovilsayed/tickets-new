<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnterzoneContoller extends Controller
{
    public function enterForm()
    {
        session()->forget('enter-zone');
        return view('pages.zone.enter');
    }
    public function enterExtraForm()
    {
        session()->forget('enter-extra-zone');
        return view('pages.zone.extra-enter');
    }

    public function enter(Request $request)
    {
        $zone = Zone::where('security_key', $request->code)->ticketZone()->first();
        if (!$zone) abort(403);
        $event = $zone->event;
        session()->put('enter-zone', [
            'zone' => $zone,
            'event' => $event,
            'id' => uniqid()
        ]);
        return redirect()->route('zone.scanner');
    }
    public function enterExtra(Request $request)
    {
        $zone = Zone::where('security_key', $request->code)->productZone()->first();
        if (!$zone) abort(403);
        $event = $zone->event;
        session()->put('enter-extra-zone', [
            'zone' => $zone,
            'event' => $event,
            'id' => uniqid()
        ]);
        return redirect()->route('extraszone.scanner');
    }

    public function scanner()
    {
        if (session()->has('enter-zone') == false) {
            abort(403);
        }

        $zone = session()->get('enter-zone')['zone'];

        $event = session()->get('enter-zone')['event'];

        $tickets = Ticket::with('user', 'product')
            ->addSelect([
                'is_checked_in' => DB::table('ticket_user')
                    ->selectRaw("case when action = 'Checked in' then 1 else 0 end")
                    ->whereColumn('ticket_user.ticket_id', 'tickets.id')
                    ->where('zone_id', $zone->id)
                    ->whereDate('ticket_user.created_at', today())
                    ->orderByDesc('ticket_user.created_at')
                    ->limit(1)
            ])
            ->when(
                request()->filled('q'),
                function (Builder $query) {
                    return $query->whereHas('user', function (Builder $query) {
                        $q = request()->q;
                        $query->where('name', 'LIKE', "%{$q}%")
                            ->orWhere('l_name', 'LIKE', "%{$q}%")
                            ->orWhere('email', 'LIKE', "%{$q}%")
                            ->orWhere('contact_number', 'LIKE', "%{$q}%")
                            ->orWhere('vatNumber', 'LIKE', "%{$q}%");
                    })->orWhere('ticket', 'LIKE', '%' . request()->q . '%');
                }
            )
            ->where('event_id', $event->id)
            ->whereHas('product', fn(Builder $query) => $query->whereJsonContains('zones', "{$zone->id}"))
            ->paginate(30);

        return view('pages.zone.scanner', [
            'zone' => $zone,
            'event' => $event,
            'tickets' => $tickets,
        ]);
    }

    public function scannerExtra()
    {
        if (session()->has('enter-extra-zone') == false) {
            abort(403);
        }
        $zone = session()->get('enter-extra-zone')['zone'];
        $event = session()->get('enter-extra-zone')['event'];
        return view('pages.zone.extra-scanner', compact('zone', 'event'));
    }
}
