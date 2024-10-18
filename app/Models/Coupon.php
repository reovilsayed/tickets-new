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

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getProducts()
    {
        if ($this->products->count()) {
            return $this->products;
        } elseif ($this->event) {
            return $this->event->products->where('status', 1);
        } else {
            return collect([]);
        }
    }
}
