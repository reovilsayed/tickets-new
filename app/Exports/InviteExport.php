<?php

namespace App\Exports;

use App\Models\Invite;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;

class InviteExport implements FromCollection
{
    protected $data;

    // Pass the request data via the constructor
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {

        $headings = collect([['Event','Person Name','Invite Name','Link']]);

        return $headings->merge($this->data);
    }
}
