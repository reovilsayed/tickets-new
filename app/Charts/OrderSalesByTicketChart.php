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
            'Digital' => $event->digitalTickets->sum('price'),
            'Physical' => $event->physicalTickets->sum('price'),
        ];

        $chart = $this->chart->pieChart()
            ->setTitle('Sales report')
            ->setLabels(array_keys($data)) // Set the labels here
            ->setDataset(array_values($data)); // Set the data here
        return $chart;
    }

}
