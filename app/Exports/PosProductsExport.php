<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PosProductsExport implements FromCollection, WithHeadings, WithTitle
{
    protected $tickets;
    protected $extras;

    public function __construct($tickets, $extras)
    {
        $this->tickets = $tickets;
        $this->extras = $extras;
    }

    public function collection()
    {
        $data = collect();
        
        // Add tickets
        foreach ($this->tickets as $ticket) {
            $data->push([
                'type' => 'Ticket',
                'name' => $ticket->product?->name,
                'quantity' => $ticket->total,
            ]);
        }
        
        // Add extras
        foreach ($this->extras as $extra) {
            $data->push([
                'type' => 'Product',
                'name' => $extra->name,
                'quantity' => $extra->qty,
            ]);
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'Type',
            'Name',
            'Quantity',
        ];
    }

    public function title(): string
    {
        return 'Products_Sold';
    }
}