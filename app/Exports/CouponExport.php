<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class CouponExport implements FromCollection
{

    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $headings = collect([['code','discount','expire_at', 'limit', 'minimum_cart', 'used','products','created_at']]);

        return $headings->merge($this->data);
    }
}
