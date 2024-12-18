<?php

namespace App\Charts;

use App\Models\Event;
use App\Models\Product;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class EventTicketSellChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(Event $event): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $ticketsByHour = $event->tickets->groupBy(function ($ticket) {
            return $ticket->created_at->format('d M');
        })->map(function ($ticket) {
            $byProduct = $ticket->groupBy('product_id')->mapWithKeys(function ($tickets, $key) {
                return [Product::find($key)->name => $tickets->count()];
            });
            $all = collect(['all' => $ticket->count()])->merge($byProduct);
            return $all;
        });

        $dataLabels = $ticketsByHour->map(function ($array) {
            return $array->keys();
        })->flatten()->unique();

        $chart =  $this->chart->lineChart()
            ->setTitle('Ticket sales of ' . $event->name)
            ->setSubtitle('Ticket sales report.');
        foreach ($dataLabels as $label) {
            $chart->addData(ucwords($label),array_values($ticketsByHour->map(fn($array) => @$array[$label] ?? 0)->toArray()));
        }
        return $chart->setXAxis(array_keys($ticketsByHour->toArray()));
    }
}
