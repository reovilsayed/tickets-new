<?php

namespace App\Charts;

use App\Models\Event;
use App\Models\Ticket;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\LineChart;

class EventTicketSellChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(Event $event): LineChart
    {
        $tickets = Ticket::withoutGlobalScope('validTicket')
            ->selectRaw("DATE(tickets.created_at) as date")
            ->selectRaw("count(case when tickets.type = 'physical' then 1 end) as physical")
            ->selectRaw("count(case when tickets.type = 'invite' then 1 end) as invited")
            ->selectRaw("count(case when tickets.type not in ('invite', 'physical') then 1 end) as paid")
            ->leftJoin('orders', 'tickets.order_id', '=', 'orders.id')
            ->where('tickets.event_id', $event->id)
            ->where(function ($query) {
                return $query->where('orders.status', 1)
                    ->where('orders.payment_status', 1)
                    ->orWhereNull('tickets.order_id');
            })
            ->groupByRaw('DATE(tickets.created_at)')
            ->get();
        // dd($tickets->sum('sales'));

        return $this->chart->lineChart()
            ->setTitle('Ticket sales of ' . $event->name)
            ->setSubtitle('Ticket sales report.')
            ->setXAxis($tickets->pluck('date')->toArray())
            ->addData('physical Tickets', $tickets->pluck('physical')->toArray())
            ->addData('Invited Tickets', $tickets->pluck('invited')->toArray())
            ->addData('Paid Tickets', $tickets->pluck('paid')->toArray());
    }

    // public function build(Event $event): \ArielMejiaDev\LarapexCharts\LineChart
    // {
    //     $ticketsByHour = $event->tickets->groupBy(function ($ticket) {
    //         return $ticket->created_at->format('d M');
    //     })->map(function ($ticket) {
    //         $byProduct = $ticket->groupBy('product_id')->mapWithKeys(function ($tickets, $key) {
    //             return [Product::find($key)->name => $tickets->count()];
    //         });
    //         $all = collect(['all' => $ticket->count()])->merge($byProduct);
    //         return $all;
    //     });

    //     $dataLabels = $ticketsByHour->map(function ($array) {
    //         return $array->keys();
    //     })->flatten()->unique();

    //     $chart =  $this->chart->lineChart()
    //         ->setTitle('Ticket sales of ' . $event->name)
    //         ->setSubtitle('Ticket sales report.');

    //     foreach ($dataLabels as $label) {
    //         $chart->addData(ucwords($label),array_values($ticketsByHour->map(fn($array) => @$array[$label] ?? 0)->toArray()));
    //     }

    //     return $chart->setXAxis(array_keys($ticketsByHour->toArray()));
    // }
}
