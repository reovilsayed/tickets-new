<?php

namespace App\Http\Controllers;

use App\Charts\EventTicketSellChart;
use App\Charts\OrderSalesByTicketChart;
use App\Charts\OrderSalesChart;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use App\Services\EventReport;
use Illuminate\Http\Request;

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
        return view('vendor.voyager.events.ticket-sales-analytics', compact('event', 'lineChart', 'pieChart'));
    }
    public function customerReport(Event $event)
    {
        $users = $event->orders()->has('user')->when(request()->filled('q'), function ($query) {
            return $query->whereHas('user', function ($query) {
                $query->where('name', 'LIKE', '%' . request()->q . '%')->orWhere('l_name', 'LIKE', '%' . request()->q . '%');
            });
        })->distinct('user_id')->pluck('user_id')->map(fn($user) => User::find($user));
        return view('vendor.voyager.events.ticket-customer-report', compact('users', 'event'));
    }

    public function  customerReportOrders(Event $event, User $user)
    {

        $orders = Order::where('event_id', $event->id)->where('payment_status', 1)->where('user_id', $user->id);
        if (request()->has('search') && request('search') !== '') {
            $search = request('search');
            $orders->where(function ($q) use ($search) {
                $q->where('id', $search);
            });
        }
        $ordersByStatus = (clone $orders)->get()->groupBy(fn($order) => $order->getStatus())->map(fn($orders) => $orders->count());
        $orders = $orders->paginate('10');
        return view('vendor.voyager.events.orders', compact('orders', 'event', 'user', 'ordersByStatus'));
    }
    public function  customerReportTickets(Event $event, User $user)
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
                $query->where('name', 'LIKE', '%' . request()->q . '%')->orWhere('l_name', 'LIKE', '%' . request()->q . '%');
            });
        })->when(request()->filled('ticket'), function ($query) {
            return $query->where('product_id', request()->ticket);
        })->when(request()->filled('zone'), function ($query) {
            return $query->where('check_in_zone', request()->zone)->orWhere('check_out_zone', request()->zone);
        })->paginate(25);
        return view('vendor.voyager.events.checkin', compact('event', 'tickets'));
    }
}
