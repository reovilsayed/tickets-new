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
        $users = $event->tickets()->has('user')->distinct('user_id')->pluck('user_id')->map(fn($user) => User::find($user));
        return view('vendor.voyager.events.ticket-customer-report', compact('users', 'event'));
    }

    public function  customerReportOrders(Event $event, User $user,)
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
    
}
