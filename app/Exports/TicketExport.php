<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;

class TicketExport implements FromCollection
{
    public $tickets;
    public function __construct($tickets)
    {
        $this->tickets = $tickets;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $headings = collect([['ID', 'Ticket', 'Event', 'Product', 'Dates']]);
        $data = $headings->merge($this->tickets);

        return $data;
    }
}
