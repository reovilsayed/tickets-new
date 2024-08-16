<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

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
        return view('pages.zone.scanner', compact('zone', 'event'));
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
