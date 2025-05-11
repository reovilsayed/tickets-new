<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 1)
            ->where('featured', 1)
            ->orderBy('sequence', 'asc')
            ->get();

        return view('pages.events.index', ['events' => $events]);
    }

    public function show(Event $event)
    {
       
        $is_invite = false;
        $products = [];
        $now = Carbon::now();

        $products['all'] = $event->products()
        ->whereIn('type', ['website', 'both'])
        ->where('invite_only', 0)
        ->where('start_sell', '<=', $now)
        ->where('end_sell', '>=', $now)
        ->get();

        foreach ($event->dates() as $date) {
            $products[$date] = $event->products()
                ->whereIn('type', ['website', 'both'])
                ->where('invite_only', 0)
                ->where('start_sell', '<=', $now)
                ->where('end_sell', '>=', $now)
                ->get()
                ->filter(fn($product) => in_array($date, $product->dates));
        }

        return view('pages.events.show', [
            'event' => $event,
            'products' => $products,
            'is_invite' => $is_invite,
        ]);
    }
}
