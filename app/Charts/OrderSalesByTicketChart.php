<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class OrderSalesByTicketChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($event): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $tickets = $event->tickets()->has('order')->get()->groupBy(fn($ticket) => $ticket->product->name)->map(fn($tickets) => $tickets->sum('price'))->toArray();

        return $this->chart->pieChart()
            ->setTitle('Sales report ')
            ->addData(array_values($tickets))
            ->setLabels(array_keys($tickets));
    }
}
