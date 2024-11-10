<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PosDashboardReport extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $events = Event::where('status', 1)->get();

        $orders = Order::where('pos_id', $user->id)
            ->when(request()->filled('event'), fn($query) => $query->where('event_id', request()->event))
            ->when(request()->filled('date'), fn($query) => $query->whereBetween('created_at', [Carbon::parse(request()->date)->startOfDay(), Carbon::parse(request()->date)->endOfDay()]))
            ->get();
        $allorders = Order::where('pos_id', $user->id)->latest()
            ->when(request()->filled('event'), fn($query) => $query->where('event_id', request()->event))
            ->when(request()->filled('date'), fn($query) => $query->whereBetween('created_at', [Carbon::parse(request()->date)->startOfDay(), Carbon::parse(request()->date)->endOfDay()]))
            ->when(request()->filled('alert'), fn($query) => $query->where('alert', request()->alert))
          
            ->when(request()->filled('search'), function ($query) {
                $query->whereHas('user', fn($q) => $q->where('name','LIKE','%'.request()->search.'%')->orWhere('email','LIKE','%'.request()->search.'%')->orWhere('contact_number','LIKE','%'.request()->search.'%'));
            })
            ->paginate(50);

        $tickets = Ticket::where('pos_id', $user->id)
            ->when(request()->filled('event'), fn($query) => $query->where('event_id', request()->event))
            ->when(request()->filled('date'), fn($query) => $query->whereBetween('created_at', [Carbon::parse(request()->date)->startOfDay(), Carbon::parse(request()->date)->endOfDay()]))
            ->get();
        $extras =  $this->getExtras($user);
        $extras = $extras->filter()->values();

        return view('pos-report', compact(['user', 'orders', 'tickets', 'events', 'extras', 'allorders']));
    }

    protected function getExtras($user)
    {
        $extras = Order::where('pos_id', $user->id)
            ->whereNotNull('extras')
            ->when(request()->filled('event'), fn($query) => $query->where('event_id', request()->event))
            ->when(request()->filled('date'), fn($query) => $query->whereBetween('created_at', [Carbon::parse(request()->date)->startOfDay(), Carbon::parse(request()->date)->endOfDay()]))
            ->select('extras')
            ->get()
            ->map(fn($order) => $order->extras)->flatten();
        return $extras;
    }
}
