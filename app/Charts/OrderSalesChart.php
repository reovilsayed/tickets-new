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
                array_push($values,$ticket[$date]);
            }
          
            $chart->addData($name,$values);
        }

        return $chart->setXAxis($dates);
    }
}
