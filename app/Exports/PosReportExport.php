<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PosReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $event;
    protected $request;
    protected $data;

    public function __construct(Event $event, $request, $data)
    {
        $this->event = $event;
        $this->request = $request;
        $this->data = $data;
    }

    public function collection()
    {
        // We'll use the data passed to the constructor rather than querying again
        return collect([$this->data]);
    }

    public function headings(): array
    {
        return [
            'Event Name',
            'Date',
            'Staff',
            'Total Amount',
            'Card Amount',
            'Cash Amount',
            'Total Tickets Sold',
            'Total Products Sold',
            'Products Amount',
            'Tickets Amount',
            'Paid Invites Amount',
            'Paid Invites Count',
        ];
    }

    public function map($data): array
    {
        return [
            $this->event->name,
            $this->request->date ?? 'All Dates',
            $this->request->staff ? $this->data['staff_name'] : 'All Staff',
            $data['total_amount'],
            $data['card_amount'],
            $data['cash_amount'],
            $data['tickets_count'],
            $data['products_count'],
            $data['products_amount'],
            $data['tickets_amount'],
            $data['paid_invites_amount'],
            $data['paid_invites_count'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}