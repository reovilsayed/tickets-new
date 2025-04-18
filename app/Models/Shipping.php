<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    protected static function booted()
    {
        static::saving(function ($shipping) {
            if ($shipping->default) {
                // Set default to false for all other records
                static::where('id', '!=', $shipping->id)->update(['default' => false]);
            }
        });
    }
}
