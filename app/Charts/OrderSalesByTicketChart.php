<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\PieChart;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class OrderSalesByTicketChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($digital, $physical): PieChart
    {
        $chart = $this->chart->pieChart()
            ->setTitle('Sales report')
            ->setLabels(['Digital', 'Physical'])
            ->setDataset([$digital, $physical]);

        return $chart;
    }
}
