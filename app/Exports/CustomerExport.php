<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomerExport implements FromCollection
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
        $headings = collect([['First Name','Last Name','Email', 'Contact Number', 'Vat Number', 'Events']]);

        return $headings->merge($this->data);
    }
}
