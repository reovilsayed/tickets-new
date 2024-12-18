<?php

namespace App\Http\Controllers;

use App\Charts\EventTicketSellChart;
use App\Charts\OrderSalesByTicketChart;
use App\Charts\OrderSalesChart;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use App\Services\CheckoutService;
use App\Services\EventReport;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sohoj;

class EventAnalyticsController extends Controller
{

    public function index(Event $event)
    {
        $totalOrder = Order::where('event_id', $event->id)
            ->selectRaw('sum(case when pos_id is null then total end) as online_cost')
            ->selectRaw('sum(case when pos_id is not null then total end) as pos_cost')
            ->where('payment_status', 1)
            ->groupBy('event_id')
            ->first();

        $totalTicket = Ticket::withoutGlobalScope('validTicket')
            ->selectRaw("count(case when type = 'web' then 1 end) as digital")
            ->selectRaw("count(case when type = 'pos' then 1 end) as pos")
            ->selectRaw("count(case when type = 'invite' then 1 end) as invite")
            ->selectRaw("count(distinct user_id) as customer")
            ->selectRaw("sum(case when type = 'pos' then price end) as price")
            ->whereHas('order', fn(Builder $query) => $query->where('payment_status', 1))
            ->where('event_id', $event->id)
            ->groupBy('event_id')
            ->first();

        $physicalTicket = Ticket::withoutGlobalScope('validTicket')
            ->where('event_id', $event->id)
            ->where('type', 'physical')
            ->count();

        $event->loadCount(['products', 'invites', 'extras']);

        return view('vendor.voyager.events.analytics', [
            'event' => $event,
            'totalOrder' => $totalOrder,
            'totalTicket' => $totalTicket,
            'physicalTicket' => $physicalTicket,
        ]);
    }
    protected function getExtras($event_id)
    {
        $extras = Order::whereNotNull('pos_id')->where('event_id', $event_id)
            ->whereNotNull('extras')
            ->select('extras')
            ->get()
            ->map(fn($order) => $order->extras)->flatten();
        return $extras;
    }

    public function ticketParticipanReport(
        Event $event,
        // EventTicketSellChart $ticketSoldChart
    ) {
        $report = EventReport::generate($event);

        // $ticketSoldChart = $ticketSoldChart->build($event);

        return view('vendor.voyager.events.ticket-particiapants-analytics', [
            'event' => $event,
            'report' => $report,
            // 'ticketSoldChart' => $ticketSoldChart,
        ]);
    }

    public function salesReport(
        Event $event,
        OrderSalesChart $orderSalesLineChart,
        OrderSalesByTicketChart $orderSalesByTicketPiChart
    ) {
        $totalOrder = Order::whereBelongsTo($event)
            ->selectRaw('sum(case when pos_id is null and payment_status = 1 then total end) as online_cost')
            ->selectRaw('sum(case when pos_id is null and payment_status = 1 then tax end) as online_tax')
            ->selectRaw('sum(case when pos_id is null and payment_status = 3 then total end) as refund_online_cost')
            ->selectRaw('sum(case when pos_id is null and payment_status = 3 then tax end) as refund_online_tax')
            ->selectRaw('sum(case when pos_id is not null and payment_status = 1 then total end) as pos_cost')
            ->selectRaw('sum(case when pos_id is not null and payment_status = 1 then tax end) as pos_tax')
            ->selectRaw('sum(case when pos_id is not null and payment_status = 3 then total end) as refund_pos_cost')
            ->selectRaw('sum(case when pos_id is not null and payment_status = 3 then tax end) as refund_pos_tax')
            ->groupBy('event_id')
            ->first();

        $order = [
            'total' => [
                'total' => [
                    'total' => Sohoj::price($totalOrder?->online_cost + $totalOrder?->pos_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->online_cost + $totalOrder?->pos_cost - ($totalOrder?->online_tax + $totalOrder?->pos_tax))
                ],
                'refunded' => [
                    'total' => Sohoj::price($totalOrder?->refund_online_cost + $totalOrder?->refund_pos_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->refund_online_cost + $totalOrder?->refund_pos_cost - ($totalOrder?->refund_online_tax + $totalOrder?->refund_pos_tax))
                ],
            ],
            'digital' => [
                'total' => [
                    'total' => Sohoj::price($totalOrder?->online_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->online_cost - $totalOrder?->online_tax),
                ],
                'refunded' => [
                    'total' => Sohoj::price($totalOrder?->refund_online_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->refund_online_tax),
                ],
            ],
            'physical' => [
                'total' => [
                    'total' => Sohoj::price($totalOrder?->pos_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->pos_cost - $totalOrder?->pos_tax),
                ],
                'refunded' => [
                    'total' => Sohoj::price($totalOrder?->refund_pos_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->refund_pos_tax),
                ],
            ],
        ];

        $lineChart = $orderSalesLineChart->build($event);
        $pieChart = $orderSalesByTicketPiChart->build($totalOrder?->online_cost, $totalOrder?->pos_cost);

        return view('vendor.voyager.events.ticket-sales-analytics', [
            'event' => $event,
            'pieChart' => $pieChart,
            'lineChart' => $lineChart,
            'order' => $order,
            'totalOrder' => $totalOrder,
        ]);
    }

    public function customerReport(Event $event)
    {
        $users = User::whereHas('orders', function (Builder $builder) use ($event) {
            return $builder->whereBelongsTo($event);
        })
            ->where(function (Builder $builder) {
                if (request()->filled('q')) {
                    $q = request()->q;
                    return $builder->where('name', 'LIKE', "%{$q}%")
                        ->orWhere('l_name', 'LIKE', "%{$q}%")
                        ->orWhere('email', 'LIKE', "%{$q}%")
                        ->orWhere('contact_number', 'LIKE', "%{$q}%")
                        ->orWhere('vatNumber', 'LIKE', "%{$q}%");
                }
            })
            ->paginate(40);

        return view('vendor.voyager.events.ticket-customer-report', [
            'users' => $users,
            'event' => $event,
        ]);
    }

    public function invitesReport(Event $event)
    {
        $customers = $event->orders()->where('payment_method', 'invite')->select('billing')->when(request()->filled('q'), function ($query) {
            return $query->where('billing', 'LIKE', '%' . request()->q . '%');
        })->distinct()->get()->map(fn($order) => ['name' => $order->billing->name, 'email' => $order->billing->email]);
        return view('vendor.voyager.events.ticket-invites-report', compact('customers', 'event'));
    }

    public function inviteReportOrders(Event $event, Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        $orders = Order::where('event_id', $event->id)->where('payment_method', 'invite')->whereJsonContains('billing', ['name' => $request->name, 'email' => $request->email]);
        if (request()->has('search') && request('search') !== '') {
            $search = request('search');
            $orders->where(function ($q) use ($search) {
                $q->where('id', $search);
            });
        }

        $orders = $orders->get();
        return view('vendor.voyager.events.invites.orders', compact('orders', 'event'));
    }
    public function inviteReportTickets(Event $event, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        $tickets = Ticket::where('event_id', $event->id)->where('type', 'invite')->whereJsonContains('owner', ['name' => $request->name, 'email' => $request->email]);
        if (request()->has('search') && request('search') !== '') {
            $search = request('search');
            $tickets->where(function ($q) use ($search) {
                $q->where('id', $search);
            });
        }
        $ticketsByStatus = (clone $tickets)->get()->groupBy(fn($ticket) => $ticket->status())->map(fn($tickets) => $tickets->count());
        $tickets = $tickets->get();

        return view('vendor.voyager.events.invites.tickets', compact('tickets', 'event', 'ticketsByStatus'));
    }
    public function customerReportOrders(Event $event, User $user)
    {

        $orders = Order::where('event_id', $event->id)->where('payment_status', 1)->where('user_id', $user->id);
        if (request()->has('search') && request('search') !== '') {
            $search = request('search');
            $orders->where(function ($q) use ($search) {
                $q->where('id', $search);
            });
        }
        $ordersByStatus = (clone $orders)->get()->groupBy(fn($order) => $order->getStatus())->map(fn($orders) => $orders->count());
        $orders = $orders->get();
        return view('vendor.voyager.events.orders', compact('orders', 'event', 'ordersByStatus'));
    }
    public function customerReportTickets(Event $event, User $user)
    {
        $tickets = Ticket::where('event_id', $event->id)->where('user_id', $user->id);
        if (request()->has('search') && request('search') !== '') {
            $search = request('search');
            $tickets->where(function ($q) use ($search) {
                $q->where('id', $search);
            });
        }
        $ticketsByStatus = (clone $tickets)->get()->groupBy(fn($ticket) => $ticket->status())->map(fn($tickets) => $tickets->count());

        $tickets = $tickets->paginate('10');

        return view('vendor.voyager.events.tickets', compact('tickets', 'event', 'user', 'ticketsByStatus'));
    }

    public function checkinReport(Event $event, Request $request)
    {
        $staffs = User::select(['id', 'name', 'l_name'])
            ->where('role_id', 4)
            ->get();

        $tickets = $event->tickets()
            ->with([
                'user:id,name,l_name,email,contact_number',
                'product:id,name',
                'checkIn',
                'checkOut',
            ])
            ->when(request()->filled('q'), function ($query) {
                return $query->whereHas('user', function ($query) {
                    $query->where('name', 'LIKE', '%' . request()->q . '%')
                        ->orWhere('l_name', 'LIKE', '%' . request()->q . '%')
                        ->orWhere('email', 'LIKE', '%' . request()->q . '%')
                        ->orWhere('contact_number', 'LIKE', '%' . request()->q . '%')
                        ->orWhere('vatNumber', 'LIKE', '%' . request()->q . '%');
                })->orWhere('ticket', 'LIKE', '%' . request()->q . '%');
            })
            ->where(function ($query) {
                $query->when(request()->filled('ticket'), function ($query) {
                    return $query->where('product_id', request()->ticket);
                })->when(request()->filled('zone'), function ($query) {
                    return $query->where('check_in_zone', request()->zone)
                        ->orWhere('check_out_zone', request()->zone);
                });
            })
            ->paginate(25);

        $products = DB::table('tickets')
            ->select('products.name')
            ->selectRaw('count(*) as total')
            ->join('ticket_user', 'tickets.id', 'ticket_user.ticket_id')
            ->join('products', 'products.id', 'tickets.product_id')
            ->when(
                $request->filled('staff'),
                fn($query) => $query->where('ticket_user.user_id', $request->staff)
            )
            ->when(
                $request->filled('date'),
                fn($query) => $query->whereDate('ticket_user.created_at', $request->date)
            )
            ->groupBy('tickets.product_id')
            ->get();

        $zones = DB::table('zones')
            ->select('zones.name')
            ->selectRaw('count(*) as total')
            ->join('ticket_user', 'zones.id', 'ticket_user.zone_id')
            ->when(
                $request->filled('staff'),
                fn($query) => $query->where('ticket_user.user_id', $request->staff)
            )
            ->when(
                $request->filled('date'),
                fn($query) => $query->whereDate('ticket_user.created_at', $request->date)
            )
            ->groupBy('zones.id')
            ->get();

        $products = $products->merge($zones);

        return view('vendor.voyager.events.checkin', [
            'event' => $event,
            'staffs' => $staffs,
            'tickets' => $tickets,
            'products' => $products,
        ]);
    }

    public function giveAccessPage(Event $event, User $user)
    {
        $tickets = $event->products()->where('status', 1)->where('invite_only', 0)->get();

        return view('vendor.voyager.events.access-event-ticket', compact('user', 'tickets', 'event'));
    }

    public function giveAccessSubmit(Request $request, Event $event, User $user)
    {
        try {

            $order =  CheckoutService::create(event: $event, user: $user, request: $request, isFree: true);
            return redirect()->route('voyager.events.customer.analytics.tickets', [$event, $user])->with([
                'type' => 'success',
                'message' => 'Ticket added'
            ]);
        } catch (Exception | Error $e) {
            return redirect()->back()->with([
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
