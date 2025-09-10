<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CountryExport implements FromCollection, WithHeadings, WithMapping
{
    protected $country;

    public function __construct($country)
    {

        $this->country = $country;
    }

    public function collection()
    {

        return $this->country;
    }

    public function headings(): array
    {
        return [
            'TRATAMENTO',
            'TITULO_ACADEMICO',
            'Nome',
            'EMPRESA',
            'Morada',
            'Cod_postal',
            'PAIS',
        ];
    }

    public function map($record): array
    {

        $user = $record->user;

        $order = $record->magazineOrder;

        $shipping   = $order && $order->shipping_info ? json_decode($order->shipping_info, true) : [];
        $postalCity = '';
        if (! empty($shipping['postal_code']) || ! empty($shipping['city'])) {
            $postalCity = trim(($shipping['postal_code'] ?? '') . ',' . ($shipping['city'] ?? ''));
        }

        return [
            '',
            '',
            $user?->name ?? '',
            '',
            $shipping['address'] ?? '',
            $postalCity,
            $shipping['country'] ?? '',
        ];
    }
}
