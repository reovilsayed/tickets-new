<?php
namespace App\Http\Controllers;

use App\Events\OrderIsPaid;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use App\Models\WithdrawLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PosDashboardReport extends Controller
{
    public function __invoke($token = null)
    {

        $app = false;
        if ($token) {
            $app = true;
        }
        $user = auth()->check() ? auth()->user() : User::whereHas('tokens', fn($query) => $query->where('name', 'authToken')->where('token', $token))->first();
        if (! $user) {
            abort(403, 'Unauthorized');
        }

        $events = Event::where('status', 1)->where('in_pos', 1)->get();

        $orders = Order::where('pos_id', $user->id)
            ->when(request()->filled('alert'), fn($query) => $query->where('alert', request()->alert))
            ->when(request()->filled('event'), fn($query) => $query->where('event_id', request()->event))
            ->when(request()->filled('date'), fn($query) => $query->whereBetween('created_at', [Carbon::parse(request()->date)->startOfDay(), Carbon::parse(request()->date)->endOfDay()]))
            ->get();
        $allorders = Order::where('pos_id', $user->id)->latest()
        
            ->when(request()->filled('event'), fn($query) => $query->where('event_id', request()->event))
            ->when(request()->filled('date'), fn($query) => $query->whereBetween('created_at', [Carbon::parse(request()->date)->startOfDay(), Carbon::parse(request()->date)->endOfDay()]))
            ->when(request()->filled('alert'), fn($query) => $query->where('alert', request()->alert))

            ->when(request()->filled('search'), function ($query) {
                $query->whereHas('user', fn($q) => $q->where('name', 'LIKE', '%' . request()->search . '%')->orWhere('email', 'LIKE', '%' . request()->search . '%')->orWhere('contact_number', 'LIKE', '%' . request()->search . '%'));
            })
            ->withCount('tickets')
            ->paginate(50);
        $cardAmount   = $orders->where('payment_method', 'Card')->sum('total');
        $cashAmount   = $orders->where('payment_method', 'Cash')->sum('total');
        $markedAmount = $orders->whereIn('alert', ['marked', 'resolved'])->whereIn('payment_method', ['Card', 'Cash'])->sum('total');
        $totalAmount  = $cardAmount + $cashAmount - $markedAmount;

        $tickets = Ticket::where('pos_id', $user->id)
            ->when(request()->filled('event'), fn($query) => $query->where('event_id', request()->event))
            ->when(request()->filled('date'), fn($query) => $query->whereBetween('created_at', [Carbon::parse(request()->date)->startOfDay(), Carbon::parse(request()->date)->endOfDay()]))
            ->get();

        $eventId = request()->event;

        $totalPaidInvite = Ticket::where('event_id', $eventId)
            ->when(request()->filled('date'), fn($query) => $query->whereDate('activation_date', request()->date))
            ->whereType('paid_invite')
            ->where('active', 1)
            ->whereNotNull('pos_id')
            ->get();

        $withdrawLogs = WithdrawLog::with(['event', 'ticket', 'zone', 'user', 'product'])
            ->where('event_id', $eventId)
            ->get();

        $withdrawCounts = DB::table('withdraw_logs')
            ->where('event_id', $eventId)
            ->when(
                request()->filled('date'),
                fn($query) => $query->whereDate('created_at', request()->date)
            )
            ->select('name', DB::raw('SUM(quantity) AS total'))
            ->groupBy('name')
            ->get();
        $extras = $this->getExtras($user);
        $extras = $extras->filter()->values();

        return view('pos-report', compact(['user', 'orders', 'tickets', 'events', 'extras', 'allorders', 'app', 'token', 'markedAmount', 'cardAmount', 'cashAmount', 'totalAmount', 'totalPaidInvite', 'withdrawLogs', 'withdrawCounts']))
            ->with('title', 'POS Dashboard Report');
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

    public function index(Request $request, Order $order, $token = null)
    {

        $user = auth()->check() ? auth()->user() : User::whereHas('tokens', fn($query) => $query->where('name', 'authToken')->where('token', $token))->first();
        if (! $user) {
            abort(403, 'Unauthorized');
        }

        $attributes = $request->validate([
            'note' => ['nullable', 'string', 'max:1500'],
        ]);

        $order->update(['alert' => 'marked', 'note' => $attributes['note']]);

        return redirect()->back()->with('sucess', 'Order marked');
    }

    public function update(Request $request, Order $order, $token = null)
    {
        $user = auth()->check() ? auth()->user() : User::whereHas('tokens', fn($query) => $query->where('name', 'authToken')->where('token', $token))->first();
        if (! $user) {
            abort(403, 'Unauthorized');
        }

        $attributes = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
        ]);

        $order->billing->phone = $attributes['phone'];
        $order->billing->email = $attributes['email'];
        $order->save();

        return response()->json();
    }

    public function email(Order $order, $token = null)
    {
        $user = auth()->check() ? auth()->user() : User::whereHas('tokens', fn($query) => $query->where('name', 'authToken')->where('token', $token))->first();
        if (! $user) {
            abort(403, 'Unauthorized');
        }

        $order->send_email = true;

        OrderIsPaid::dispatch($order);

        return response()->json();
    }

    public function sms(Order $order, $token = null)
    {
        $user = auth()->check() ? auth()->user() : User::whereHas('tokens', fn($query) => $query->where('name', 'authToken')->where('token', $token))->first();
        if (! $user) {
            abort(403, 'Unauthorized');
        }

        $order->send_message = true;

        OrderIsPaid::dispatch($order);

        return response()->json();
    }
}
