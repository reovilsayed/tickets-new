<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Product;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EventReport
{
    protected Event $event;

    protected $report;

    protected function __construct(Event $event)
    {
        $this->event = $event;
    }

    protected function reportByDates()
    {
        $data = [];

        $products = Ticket::with('product')
            ->select('product_id')
            ->selectRaw('min(dates) as dates')
            ->where(function (Builder $builder) {
                foreach ($this->event->dates() as $date) {
                    $builder->orWhereJsonContains('dates', $date);
                }
                return $builder;
            })
            ->where('event_id', $this->event->id)
            ->groupBy('product_id')
            ->get();

        $tickets = Ticket::withoutGlobalScope('validTicket')
            ->selectRaw('JSON_UNQUOTE(JSON_EXTRACT(dates, CONCAT("$[", n.n, "]"))) AS ticket_date')
            ->selectRaw("count(*) as participants")
            ->selectRaw("count(case when tickets.status = 1 then 1 end) as checked_in")
            ->selectRaw("count(case when orders.status = 3 then 1 end) as returned")
            ->selectRaw("count(case when type = 'invite' then 1 end) as invited_participants")
            ->selectRaw("count(case when type = 'invite' and tickets.status = 1 then 1 end) as invited_checked_in")
            ->selectRaw("count(case when type = 'invite' and orders.status = 3 then 1 end) as invited_returned")
            ->selectRaw("count(case when type = 'physical' then 1 end) as physical_participants")
            ->selectRaw("count(case when type = 'physical' and tickets.status = 1 then 1 end) as physical_checked_in")
            ->selectRaw("count(case when type = 'physical' and orders.status = 3 then 1 end) as physical_returned")
            ->join(
                DB::raw('(SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) n'),
                function ($join) {
                    $join->on(DB::raw('CHAR_LENGTH(dates) - CHAR_LENGTH(REPLACE(dates, ",", ""))'), '>=', DB::raw('n.n'));
                }
            )
            ->leftJoin('orders', 'tickets.order_id', '=', 'orders.id')
            ->where('tickets.event_id', $this->event->id)
            ->where(function ($query) {
                return $query->whereIn('orders.status', [1, 3])
                    ->where('orders.payment_status', 1)
                    ->orWhereNull('tickets.order_id');
            })
            ->groupBy(DB::raw('ticket_date'))
            ->orderBy('ticket_date')
            ->get();



        foreach ($tickets as  $ticket) {
            $data[$ticket->ticket_date] = $this->singleDayReport($ticket, $products);
        }


        $this->report['by_dates'] = $data;
    }

    private function singleDayReport($ticket, $products)
    {
        return [
            'products' => $products->filter(fn($item) => in_array($ticket->ticket_date, $item->dates))->map(fn($item) => $item->product),
            'participants' => $ticket->participants,
            'checked_in' => $ticket->checked_in,
            'returned' => $ticket->returned,
            'type' => [
                'invite' => [
                    'participants' => $ticket->invited_participants,
                    'checked_in' => $ticket->invited_checked_in,
                    'returned' => (int) $ticket->invited_returned,
                ],
                'physical' => [
                    'participants' => $ticket->physical_participants,
                    'checked_in' => $ticket->physical_checked_in,
                    'returned' => (int) $ticket->physical_returned,
                ],
                'paid' => [
                    'participants' => $ticket->participants - ($ticket->invited_participants + $ticket->physical_participants),
                    'checked_in' => $ticket->checked_in -  ($ticket->invited_checked_in + $ticket->physical_checked_in),
                    'returned' => $ticket->returned - ($ticket->invited_returned + $ticket->physical_returned),
                ]
            ]
        ];
    }

    protected function reportBySingleType($type)
    {
        $products = Ticket::withoutGlobalScope('validTicket')
            ->with('product:id,name,start_date,end_date')
            ->select('product_id')
            ->selectRaw("count(*) as participants")
            ->join('orders', 'tickets.order_id', '=', 'orders.id')
            ->selectRaw("count(case when tickets.status = 1 then 1 end) as checked_in")
            ->selectRaw("count(case when orders.status = 3 then 1 end) as returned")
            ->when(
                $type === 'invite' || $type === 'physical',
                function ($query) use ($type) {
                    
                    return $query->where('type', $type);
                }
            )
            ->where('tickets.event_id', $this->event->id)
            ->whereIn('orders.status', [1, 3])
            ->where('orders.payment_status', 1)
            ->groupBy('product_id')
            ->get();

        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'product' => $product->product,
                'participants' => $product->participants,
                'checked_in' => $product->checked_in,
                'returned' => $product->returned,
            ];
        }

        return $data;
    }

    protected function reportByTypes()
    {
        $types = ['paid', 'invite', 'physical'];

        $data = [];

        foreach ($types as $type) {
            $data[$type] = $this->reportBySingleType($type);
        }

        
        
        $this->report['by_type'] = $data;
    }

    protected function make()
    {
        $this->reportByDates();
        $this->reportByTypes();

        return $this->report;
    }

    public static function generate(Event $event)
    {
        return (new self($event))->make();
    }
}
