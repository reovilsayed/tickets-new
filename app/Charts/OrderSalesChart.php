<?php

namespace App\Charts;

use App\Models\Event;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class OrderSalesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(Event $event): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $allTickets = $event->tickets
            ->groupBy(fn($ticket) => $ticket->created_at->format('d M'))
            ->map(fn($tickets) => $tickets->sum('price'))->toArray();

        $dates = array_keys($allTickets);
        $allProducts = $event->products->pluck('name');
        
        $ticketsByProduct = $event->tickets->groupBy(function($ticket) use($dates){
            return $ticket->product->name;
        })->map(function($tickets) use($dates){
            $dates = array_fill_keys($dates, 0);
            $data = $tickets->groupBy(function($ticket){
                return $ticket->created_at->format('d M');
            })->map(fn($tickets)=>$tickets->sum('price'))->toArray();
           return array_merge($dates,$data);

        });


        $chart = $this->chart->lineChart()
            ->setTitle('Total Sale')
            ->addData('Total', array_values($allTickets));
        foreach ($ticketsByProduct as $name => $tickets) {

            $chart->addData($name, array_values($tickets));
        }
        return $chart->setXAxis(array_keys($allTickets));
    }
}
