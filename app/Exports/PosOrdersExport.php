<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PosOrdersExport implements WithColumnFormatting, WithColumnWidths, FromCollection, WithHeadings, WithMapping
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer Name',
            'Email',
            'Phone',
            'Items',
            'Total',
            'Payment Method',
            'Date',
            'Staff',
            'Invoice',
            'Note'
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->user->name,
            $order->billing->email ?? $order->user->email,
            (string) @$order->billing?->phone ?? $order->user->contact_number,
            implode("\n", $order->getDescription()),
            $order->total,
            $order->payment_method,
            $order->created_at->format('Y-m-d H:i'),
            $order->posUser ? $order->posUser->fullName() : 'N/A',
            $order->invoice_id ? "Invoice #{$order->invoice_id}" : 'N/A',
            $order->note
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '0'
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B'=>30,
            'C'=>30,
            'D'=>30,
            'E'=>30,
            'F'=>10,
            'G'=>10,
            'H'=>10,
            'I'=>10,
            'J'=>10,
            'K'=>20,
        ];
    }
}
