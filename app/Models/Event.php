<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'start_at'=>'datetime',
        'end_at'=>'datetime',
    ];
    public function path()
    {
        return route('product_details', $this->slug);
    }
}
