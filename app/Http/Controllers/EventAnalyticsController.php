<?php

namespace App\Http\Controllers;

use App\Charts\EventTicketSellChart;
use App\Charts\OrderSalesByTicketChart;
use App\Charts\OrderSalesChart;
use App\Exports\PosOrdersExport;
use App\Exports\PosProductsExport;
use App\Exports\PosReportExport;
use App\Models\Event;
use App\Models\Order;
use App\Models\Scan;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawLog;
use App\Services\CheckoutService;
use App\Services\EventReport;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
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

        $event->loadCount([
            'products',
            'products as invite_products' => fn($query) => $query->where('invite_only', 1),
            'extras',
            'invites',
        ]);

        return view('vendor.voyager.events.analytics', [
            'event'          => $event,
            'totalOrder'     => $totalOrder,
            'totalTicket'    => $totalTicket,
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
        EventTicketSellChart $ticketSoldChart
    ) {
        $report = EventReport::generate($event);

        $ticketSoldChart = $ticketSoldChart->build($event);

        return view('vendor.voyager.events.ticket-particiapants-analytics', [
            'event'           => $event,
            'report'          => $report,
            'ticketSoldChart' => $ticketSoldChart,
        ]);
    }

    public function orders(Event $event)
    {
        $orders = Order::where('event_id', $event->id)
            ->when(request('search'), function ($query, $search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where(function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('l_name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%")
                            ->orWhereRaw("CONCAT(name, ' ', l_name) LIKE ?", ["%{$search}%"]);
                    });
                });
            })
            ->latest()
            ->paginate(40);

        return view('vendor.voyager.events.orders', [
            'event'  => $event,
            'orders' => $orders,
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
            'total'    => [
                'total'    => [
                    'total'      => Sohoj::price($totalOrder?->online_cost + $totalOrder?->pos_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->online_cost + $totalOrder?->pos_cost - ($totalOrder?->online_tax + $totalOrder?->pos_tax)),
                ],
                'refunded' => [
                    'total'      => Sohoj::price($totalOrder?->refund_online_cost + $totalOrder?->refund_pos_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->refund_online_cost + $totalOrder?->refund_pos_cost - ($totalOrder?->refund_online_tax + $totalOrder?->refund_pos_tax)),
                ],
            ],
            'digital'  => [
                'total'    => [
                    'total'      => Sohoj::price($totalOrder?->online_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->online_cost - $totalOrder?->online_tax),
                ],
                'refunded' => [
                    'total'      => Sohoj::price($totalOrder?->refund_online_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->refund_online_tax),
                ],
            ],
            'physical' => [
                'total'    => [
                    'total'      => Sohoj::price($totalOrder?->pos_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->pos_cost - $totalOrder?->pos_tax),
                ],
                'refunded' => [
                    'total'      => Sohoj::price($totalOrder?->refund_pos_cost),
                    'withoutTax' => Sohoj::price($totalOrder?->refund_pos_tax),
                ],
            ],
        ];

        $lineChart = $orderSalesLineChart->build($event);
        $pieChart  = $orderSalesByTicketPiChart->build($totalOrder?->online_cost, $totalOrder?->pos_cost);

        return view('vendor.voyager.events.ticket-sales-analytics', [
            'event'      => $event,
            'pieChart'   => $pieChart,
            'lineChart'  => $lineChart,
            'order'      => $order,
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
    public function zonesReport(Event $event)
    {
        session()->put('redirect_after_action', 'zones');
        session()->put('event_id', $event->id);
        $event->load('zones');
        $zones = $event->zones()->paginate(20);
        return view('vendor.voyager.events.zones', [
            'event' => $event,
            'zones' => $zones,
        ]);
    }
    public function extraReport(Event $event, Request $request)
    {
        session()->put('redirect_after_action', 'extras');
        session()->put('event_id', $event->id);
        $extras = \App\Models\Extra::with('category')
            ->where('event_id', $event->id)
            ->paginate(20);

        return view('vendor.voyager.events.extras', compact('event', 'extras'));
    }
    public function extraCategory(Event $event, Request $request)
    {
        session()->put('redirect_after_action', 'extras');
        session()->put('event_id', $event->id);
        $extraCategory = \App\Models\ExtraCategory::where('event_id', $event->id)
            ->paginate(20);

        return view('vendor.voyager.events.extra-categories', compact('event', 'extraCategory'));
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
            'name'  => 'required',
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
            'name'  => 'required',
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
        $tickets         = $tickets->get();

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
        $orders         = $orders->get();
        return view('vendor.voyager.events.order-reports', compact('orders', 'event', 'ordersByStatus'));
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
                'scans',
            ])
            ->when(request()->filled('q'), function ($query) {
                $searchTerm = '%' . request()->q . '%';
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('ticket', 'LIKE', $searchTerm)
                        ->orWhere('extra_info', 'LIKE', $searchTerm)
                        ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(owner, '$.name')) LIKE ?", [$searchTerm])
                        ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(owner, '$.phone')) LIKE ?", [$searchTerm])
                        ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(owner, '$.email')) LIKE ?", [$searchTerm]);
                });
            })
            ->where('event_id', $event->id)
            ->when(
                request()->filled('status'),
                function ($query) {
                    if (request('status') === '1') {
                        return $query->has('scans');
                    }

                    if (request('status') === '2') {
                        return $query->doesntHave('scans');
                    }
                }
            )
            ->where(function ($query) {
                $query->when(request()->filled('ticket'), function ($query) {
                    return $query->where('product_id', request()->ticket);
                })->when(request()->filled('zone'), function ($query) {
                    return $query->where('check_in_zone', request()->zone)
                        ->orWhere('check_out_zone', request()->zone);
                });
            })
            ->paginate(20);

        // Products - Modified to show all by default
        $products = DB::table('tickets')
            ->select('products.name')
            ->selectRaw('count(DISTINCT tickets.id) as total')
            ->join('ticket_user', 'tickets.id', 'ticket_user.ticket_id')
            ->join('products', 'products.id', 'tickets.product_id')
            ->where('tickets.event_id', $event->id)
            ->when($request->filled('staff'), fn($query) => $query->where('ticket_user.user_id', $request->staff))
            ->when($request->filled('date'), fn($query) => $query->whereDate('ticket_user.created_at', $request->date))
            ->groupBy('tickets.product_id', 'products.name')
            ->get();

        // Zones - Modified to show all by default
        $zones = Scan::with('zone')
            ->select('zone_id')
            ->selectRaw("count(DISTINCT ticket_id) as total")
            ->whereHas('ticket', fn($query) => $query->where('event_id', $event->id))
            ->when($request->filled('staff'), fn($query) => $query->where('user_id', $request->staff))
            ->when($request->filled('date'), fn($query) => $query->whereDate('created_at', $request->date))
            ->groupBy('zone_id')
            ->get();

        return view('vendor.voyager.events.checkin', [
            'event'    => $event,
            'zones'    => $zones,
            'staffs'   => $staffs,
            'tickets'  => $tickets,
            'products' => $products,
        ]);
    }

    public function POS(Event $event, Request $request)
    {
        $staffs = User::select(['id', 'name', 'l_name'])
            ->where('role_id', 6)
            ->get();

        $order = Order::selectRaw('sum(total) as total')
            ->selectRaw('sum(case when payment_method = "Card" then total END) as card_amount')
            ->selectRaw('sum(case when payment_method = "Cash" then total END) as cash_amount')
            ->selectRaw('sum(case when payment_method = "QR" then total END) as qr_amount')
            ->selectRaw('SUM(jt.qty) as extra_qty')
            ->selectRaw('SUM(jt.qty * jt.price) as extra_total')
            ->leftJoin(DB::raw('JSON_TABLE(orders.extras, \'$[*]\' COLUMNS (
                        qty INT PATH \'$.qty\',
                        price INT PATH \'$.price\')) AS jt'), function ($join) {
                $join->on(DB::raw('1'), '=', DB::raw('1'));
            })
            ->when(
                $request->filled('date'),
                fn($query) => $query->whereDate('created_at', $request->date)
            )
            ->where('orders.event_id', $event->id)
            ->whereNotNull('orders.pos_id')
            ->when(
                $request->filled('staff'),
                fn($query) => $query->where('orders.pos_id', $request->staff)
            )
            ->first();
        $order_total = Order::when(
            request()->filled('alert') && request()->alert !== 'all',
            fn($query) => $query->where('alert', request()->alert)
        )->selectRaw('sum(total) as total')

            ->selectRaw('sum(case when payment_method = "Card" then total END) as card_amount')
            ->selectRaw('sum(case when payment_method = "Cash" then total END) as cash_amount')
            ->selectRaw('sum(case when payment_method = "QR" then total END) as qr_amount')
            ->when(
                $request->filled('date'),
                fn($query) => $query->whereDate('created_at', $request->date)
            )
            ->where('orders.event_id', $event->id)
            ->whereNotNull('orders.pos_id')
            ->when(
                $request->filled('staff'),
                fn($query) => $query->where('orders.pos_id', $request->staff)
            )
            ->first();
        $extras = Order::when(
            request()->filled('alert') && request()->alert !== 'all',
            fn($query) => $query->where('alert', request()->alert)
        )->select('jt.name as name')
            ->selectRaw("SUM(jt.qty) AS qty")
            ->from(DB::raw("
            orders,
            JSON_TABLE(
                extras,
                '$[*]' COLUMNS (
                    id INT PATH '$.id',
                    name VARCHAR(255) PATH '$.name',
                    qty INT PATH '$.qty'
                )
            ) AS jt
        "))
            ->where('orders.event_id', $event->id)
            ->whereNotNull('jt.id')
            ->when(
                $request->filled('date'),
                fn($query) => $query->whereDate('created_at', $request->date)
            )
            ->when(
                $request->filled('staff'),
                fn($query) => $query->where('orders.pos_id', $request->staff)
            )
            ->whereNotNull('orders.pos_id')
            ->groupBy('jt.id', 'jt.name')
            ->get();

        $tickets = Ticket::with('product:id,name')
            ->select('product_id')
            ->selectRaw('count(*) as total')
            ->where('event_id', $event->id)
            ->when(
                $request->filled('date'),
                fn($query) => $query->whereDate('created_at', $request->date)
            )
            ->when(
                $request->filled('staff'),
                fn($query) => $query->where('pos_id', $request->staff)
            )
            ->whereType('pos')
            ->groupBy('product_id')
            ->get();

        $allOrders = Order::with('user')
            ->where('event_id', $event->id)
            ->when(
                request()->filled('alert') && request()->alert !== 'all',
                fn($query) => $query->where('alert', request()->alert)
            )
            ->when(
                request()->filled('search'),
                function (Builder $query) {
                    $query->whereHas('user', fn($q) => $q->where('name', 'LIKE', '%' . request()->search . '%')
                        ->orWhere('email', 'LIKE', '%' . request()->search . '%')
                        ->orWhere('contact_number', 'LIKE', '%' . request()->search . '%'));
                }
            )
            ->when(
                $request->filled('date'),
                fn($query) => $query->whereDate('created_at', $request->date)
            )
            ->whereNotNull('pos_id')
            ->when(
                $request->filled('staff'),
                fn($query) => $query->where('pos_id', $request->staff)
            )
            ->latest()
            ->withCount('tickets')
            ->paginate(50);
        $markedAmount = Order::where('event_id', $event->id)
            ->whereNotNull('pos_id')
            ->whereIn('payment_method', ['Card', 'Cash'])
            ->whereIn('alert', ['marked', 'resolved'])
            ->when(
                $request->filled('date'),
                fn($query) => $query->whereDate('created_at', $request->date)
            )
            ->when(
                $request->filled('staff'),
                fn($query) => $query->where('orders.pos_id', $request->staff)
            )
            ->sum('total') / 100;

        $totalPaidInvite = Ticket::where('event_id', $event->id)
            ->when($request->filled('date'), fn($query) => $query->whereDate('activation_date', $request->date))
            ->when($request->filled('staff'), fn($query) => $query->where('pos_id', $request->staff))
            ->whereType('paid_invite')
            ->where('active', 1)
            ->whereNotNull('pos_id')
            ->get();
        $withdrawLogs = WithdrawLog::with(['event', 'ticket', 'zone', 'user', 'product'])
            ->where('event_id', $event->id)
            ->get();
        $withdrawCounts = DB::table('withdraw_logs')
            ->where('event_id', $event->id)
            ->when(
                $request->filled('date'),
                fn($query) => $query->whereDate('created_at', $request->date)
            )->when(
                $request->filled('staff'),
                fn($query) => $query->where('user_id', $request->staff)
            )

            ->select('name', DB::raw('SUM(quantity) AS total'))
            ->groupBy('name')
            ->get();
            // dd($order_total);

        if ($request->has('export')) {
            if ($request->export == 'summary') {
                $exportData = [
                    'total_amount'        => Sohoj::price($order_total?->total, false),
                    'card_amount'         => Sohoj::price($order_total?->card_amount, false),
                    'cash_amount'         => Sohoj::price($order_total?->cash_amount, false),
                    'qr_amount'           => Sohoj::price($order_total?->qr_amount, false),
                    'tickets_count'       => $tickets->sum('total') ?? 0,
                    'products_count'      => $order->extra_qty ?? 0,
                    'products_amount'     => Sohoj::price($order?->extra_total, false),
                    'tickets_amount'      => Sohoj::price($order?->total - $order?->extra_total, false),
                    'paid_invites_amount' => Sohoj::price($totalPaidInvite->sum('price'), false),
                    'paid_invites_count'  => $totalPaidInvite->count(),
                    'staff_name'          => $request->filled('staff') ?
                        $staffs->firstWhere('id', $request->staff)->fullName() : null,
                ];

                return Excel::download(
                    new PosReportExport($event, $request, $exportData),
                    "{$event->name}_pos_summary.xlsx"
                );
            } elseif ($request->export == 'products') {
                return Excel::download(
                    new PosProductsExport($tickets, $extras),
                    "{$event->name}_pos_products_sell.xlsx"
                );
            } else {
                return Excel::download(
                    new PosOrdersExport($allOrders),
                    "{$event->name}_pos_orders.xlsx"
                );
            }
        }
        //  return $order_test->getDescription();
        return view('vendor.voyager.events.pos', [
            'event'           => $event,
            'order'           => $order,
            'staffs'          => $staffs,
            'extras'          => $extras,
            'tickets'         => $tickets,
            'allOrders'       => $allOrders,
            'totalPaidInvite' => $totalPaidInvite,
            'order_total'     => $order_total,
            'markedAmount'    => $markedAmount,
            'withdrawLogs'    => $withdrawLogs,
            'withdrawCounts'  => $withdrawCounts,
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

            $order = CheckoutService::create(event: $event, user: $user, request: $request, isFree: true);
            return redirect()->route('voyager.events.customer.analytics.tickets', [$event, $user])->with([
                'type'    => 'success',
                'message' => 'Ticket added',
            ]);
        } catch (Exception | Error $e) {
            return redirect()->back()->with([
                'type'    => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function qrWallet(Request $request, Event $event)
    {
        $this->authorize('browse', $event);
        $staffs = User::select(['id', 'name', 'l_name'])
            ->where('role_id', 8)
            ->get();

        $transactions = Transaction::with(['transactionable', 'agent'])
            ->when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('created_at', $request->date);
            })
            ->when($request->filled('staff'), function ($query) use ($request) {
                $query->where('agent_id', $request->staff);
            })
            ->get();

        $walletUserTransactions = $transactions->groupBy('transactionable_id');

        $walletUserSummaries = [];
        foreach ($walletUserTransactions as $userId => $userTransactions) {
            $user    = $userTransactions->first()->transactionable;
            $deposit = $userTransactions->where('type', 'debit')->sum('amount');
            $refund  = $userTransactions->where('type', 'credit')->sum('amount');

            $walletUserSummaries[] = [
                'user'    => $user,
                'deposit' => $deposit,
                'refund'  => $refund,
                'total'   => $deposit - $refund,
            ];
        }

        // Calculate overall totals
        $overallDeposit = $transactions->where('type', 'debit')->sum('amount');
        $overallRefund  = $transactions->where('type', 'credit')->sum('amount');
        $overallTotal   = $overallDeposit - $overallRefund;

        return view('vendor.voyager.events.qrwallet', compact(
            'event',
            'staffs',
            'walletUserSummaries',
            'overallDeposit',
            'overallRefund',
            'overallTotal',
        ));
    }
}
