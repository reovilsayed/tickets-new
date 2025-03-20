<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function path() : string
    {
        return route('magazines.show', $this);
    }
}
