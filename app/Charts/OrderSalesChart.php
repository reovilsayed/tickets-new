<?php

namespace App\Charts;

use App\Models\Event;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Order;
use Carbon\Carbon;

class OrderSalesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(Event $event): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $salesData = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m-%d") as formatted_date')
            ->selectRaw('SUM(total) as total')
            ->selectRaw('SUM(CASE WHEN pos_id IS NULL THEN total ELSE 0 END) as online_cost')
            ->selectRaw('SUM(CASE WHEN pos_id IS NOT NULL THEN total ELSE 0 END) as pos_cost')
            ->whereBelongsTo($event)
            ->where('payment_status', 1)
            ->orderBy('formatted_date')
            ->groupBy('formatted_date')
            ->get();

        $dates = $salesData->pluck('formatted_date')->toArray();
        $totalSales = $salesData->pluck('total')->toArray();
        $digitalSales = $salesData->pluck('online_cost')->toArray();
        $physicalSales = $salesData->pluck('pos_cost')->toArray();

        return $this->chart->lineChart()
            ->setTitle('Total Sales Breakdown')
            ->setXAxis($dates)
            ->addData('Total Sales', $totalSales)
            ->addData('Digital Products', $digitalSales)
            ->addData('Physical Products', $physicalSales);

        $types = ['Total', 'Digital', 'Physical'];

        $allTickets = $event->tickets
            ->groupBy(fn($ticket) => $ticket->created_at->format('d M'))
            ->map(fn($tickets) => number_format($tickets->sum('price') / 100, 2))->toArray();
        $digitalTickets = $event->digitalTickets
            ->groupBy(fn($ticket) => $ticket->created_at->format('d M'))
            ->map(fn($tickets) => number_format($tickets->sum('price') / 100, 2))->toArray();

        $physicalTickets = $event->physicalTickets
            ->groupBy(fn($ticket) => $ticket->created_at->format('d M'))
            ->map(fn($tickets) => number_format($tickets->sum('price') / 100, 2))->toArray();

        $data = [];
        foreach ($allTickets as $date => $ticket) {
            $data['Total'][$date] = $ticket;
        }
        foreach ($digitalTickets as $date => $ticket) {
            $data['Digital'][$date] = $ticket;
        }
        foreach ($physicalTickets as $date => $ticket) {
            $data['Physical'][$date] = $ticket;
        }
        $dates = array_keys($allTickets);

        foreach ($data as $name => $ticket) {
            foreach ($dates as $date) {
                $data[$name][$date] = @$data[$name][$date] ?  $data[$name][$date] : 0;
            }
        }





        $chart = $this->chart->lineChart()
            ->setTitle('Total Sale');

        foreach ($data as $name => $ticket) {

            $values = [];
            foreach ($dates as $date) {
                array_push($values, $ticket[$date]);
            }

            $chart->addData($name, $values);
        }
        // dd($data);
        // dd($chart->setXAxis($dates));
        return $chart->setXAxis($dates);
    }
}
