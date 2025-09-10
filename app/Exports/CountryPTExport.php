<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CountryPTExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

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
            'POSTAL_CODE',
            'ENDERECO_POSTAL',
        ];
    }

    public function map($record): array
    {

        $user = $record->user;

        $order = $record->magazineOrder;

        $shipping = $order && $order->shipping_info ? json_decode($order->shipping_info, true) : [];

        return [
            '',
            '',
            $user?->name ?? '',
            '',
            $shipping['address'] ?? '',
            $shipping['postal_code'] ?? '',
            $shipping['city'] ?? '',
        ];
    }

}
