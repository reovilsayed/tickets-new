<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupons_product');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
