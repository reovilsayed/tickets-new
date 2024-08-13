<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;

class EnterzoneContoller extends Controller
{
    public function enterForm()
    {

        return view('pages.zone.enter');
    }

    public function enter(Request $request)
    {
        $zone = Zone::where('security_key', $request->code)->first();
        $event = $zone->event;
        session()->put('enter-zone', [
            'zone' => $zone,
            'event' => $event,
            'id' => uniqid()
        ]);
        return redirect()->route('zone.scanner');
    }

    public function scanner(){
        $zone = session()->get('enter-zone')['zone'];
        $event = session()->get('enter-zone')['event'];
        return view('pages.zone.scanner',compact('zone','event'));
    }
}
