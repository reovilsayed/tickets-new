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
        $types = ['Total', 'Digital', 'Physical'];
        $allTickets = $event->tickets
            ->groupBy(fn($ticket) => $ticket->created_at->format('d M'))
            ->map(fn($tickets) => $tickets->sum('price'))->toArray();
        $digitalTickets = $event->digitalTickets
            ->groupBy(fn($ticket) => $ticket->created_at->format('d M'))
            ->map(fn($tickets) => $tickets->sum('price'))->toArray();

        $physicalTickets = $event->physicalTickets
            ->groupBy(fn($ticket) => $ticket->created_at->format('d M'))
            ->map(fn($tickets) => $tickets->sum('price'))->toArray();

        $data = [];
        foreach ($allTickets as $date => $ticket) {
            $data[$date]['Total'] = $ticket;
        }
        foreach ($digitalTickets as $date => $ticket) {
            $data[$date]['Digital'] = $ticket;
        }
        foreach ($physicalTickets as $date => $ticket) {
            $data[$date]['Physical'] = $ticket;
        }
        foreach ($data as $date => $ticket) {
            foreach ($types as $item) {
                $data[$date][$item] = @$data[$date][$item] ?  $data[$date][$item] : 0;
            }
        }


        $dates = array_keys($allTickets);

      

        $chart = $this->chart->lineChart()
            ->setTitle('Total Sale');
        foreach ($data as $name => $tickets) {

            $chart->addData($name, array_values($tickets));
        }
        return $chart->setXAxis(array_keys($allTickets));
    }
}
