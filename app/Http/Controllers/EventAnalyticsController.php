<?php

namespace App\Http\Controllers;

use App\Charts\EventTicketSellChart;
use App\Charts\OrderSalesByTicketChart;
use App\Charts\OrderSalesChart;
use App\Models\Event;
use App\Models\Order;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\User;
use App\Services\CheckoutService;
use App\Services\EventReport;
use Error;
use Exception;
use Illuminate\Http\Request;
use Sohoj;

class EventAnalyticsController extends Controller
{

    public function index(Event $event)
    {
        return view('vendor.voyager.events.analytics', compact('event'));
    }

    public function ticketParticipanReport(
        Event $event,
        EventTicketSellChart $ticketSoldChart
    ) {

        $report = EventReport::generate($event);

        $ticketSoldChart = $ticketSoldChart->build($event);

        return view('vendor.voyager.events.ticket-particiapants-analytics', compact('event', 'report', 'ticketSoldChart'));
    }
    public function salesReport(
        Event $event,
        OrderSalesChart $orderSalesLineChart,
        OrderSalesByTicketChart $orderSalesByTicketPiChart
    ) {
        $lineChart = $orderSalesLineChart->build($event);
        $pieChart = $orderSalesByTicketPiChart->build($event);

        $report = [
            'total' => [
                'total' => [
                    'total' => Sohoj::price(setMinValue($event->tickets->sum('price'), 0)),
                    'withoutTax' => Sohoj::price(setMinValue($event->tickets->sum('price') - $event->tickets->sum(fn($ticket) => $ticket->product->totalTax()), 0)),
                ],
                'refunded' => [
                    'total' => Sohoj::price($event->orders->where('payment_status', 1)->where('status', 3)->sum('total')),
                    'withoutTax' => Sohoj::price(setMinValue($event->orders->where('payment_status', 1)->where('status', 3)->sum('total') - $event->orders->where('payment_status', 1)->where('status', 1)->sum('tax'), 0)),

                ],
            ],
            'digital' => [
                'total' => [
                    'total' => Sohoj::price($event->orders->where('payment_status', 1)->where('status', 1)->sum('total')),
                    'withoutTax' => Sohoj::price(setMinValue($event->orders->where('payment_status', 1)->where('status', 1)->sum('total') - $event->orders->where('payment_status', 1)->where('status', 1)->sum('tax'), 0)),
                ],
                'refunded' => [
                    'total' => Sohoj::price($event->orders->where('payment_status', 1)->where('status', 3)->sum('total')),
                    'withoutTax' => Sohoj::price(setMinValue($event->orders->where('payment_status', 1)->where('status', 3)->sum('total') - $event->orders->where('payment_status', 1)->where('status', 1)->sum('tax'), 0)),

                ],
            ],
            'physical' => [
                'total' => [
                    'total' => Sohoj::price(setMinValue($event->tickets()->where('type', 'physical')->sum('price'), 0)),
                    'withoutTax' => Sohoj::price(setMinValue($event->tickets()->where('type', 'physical')->sum('price') - $event->tickets->sum(fn($ticket) => $ticket->product->totalTax()), 0)),
                ],
                'refunded' => [
                    'total' => Sohoj::price(0),
                    'withoutTax' => Sohoj::price(0),

                ],

            ],

        ];

        return view('vendor.voyager.events.ticket-sales-analytics', compact('event', 'lineChart', 'pieChart', 'report'));
    }
    public function customerReport(Event $event)
    {
        $users = $event->orders()->has('user')->when(request()->filled('q'), function ($query) {
            return $query->whereHas('user', function ($query) {
                $query->where('name', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('l_name', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('contact_number', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('vatNumber', 'LIKE', '%' . request()->q . '%');
            });
        })->distinct('user_id')->pluck('user_id')->map(fn($user) => User::find($user));
        return view('vendor.voyager.events.ticket-customer-report', compact('users', 'event'));
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
        $tickets = $event->tickets()->when(request()->filled('q'), function ($query) {
            return $query->whereHas('user', function ($query) {
                $query->where('name', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('l_name', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('email', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('contact_number', 'LIKE', '%' . request()->q . '%')
                    ->orWhere('vatNumber', 'LIKE', '%' . request()->q . '%');
            })->orWhere('ticket', 'LIKE', '%' . request()->q . '%');
        })->where(function ($query) {
            $query->when(request()->filled('ticket'), function ($query) {
                return $query->where('product_id', request()->ticket);
            })->when(request()->filled('zone'), function ($query) {
                return $query->where('check_in_zone', request()->zone)->orWhere('check_out_zone', request()->zone);
            });
        })->paginate(25);
        return view('vendor.voyager.events.checkin', compact('event', 'tickets'));
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
