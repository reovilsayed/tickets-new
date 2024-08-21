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
         $data = [
            'Digital'=>$event->digitalTickets->sum('price'),
            'Physical'=>$event->physicalTickets->sum('price'),
        ];
        return $this->chart->pieChart()
            ->setTitle('Sales report ')
            ->addData(array_values($data))
            ->setLabels(array_keys($data));
    }
}
