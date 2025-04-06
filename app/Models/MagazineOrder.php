<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagazineOrder extends Model
{
    use HasFactory;
    protected $table = 'magazine_orders';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(MagazineOrderItem::class, 'magazine_order_id', 'id');
    }
    public function billing(): Attribute
    {

        return Attribute::make(
            set: fn($value) => json_encode($value),
            get: fn($value) =>  json_decode($value)
        );
    }
}
