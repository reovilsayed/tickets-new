<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagazineOrder extends Model
{
    use HasFactory;
    protected $table = 'magazine_orders';
    protected $guarded = [];

    protected $casts = [
        'billing' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function archives()
    {
        return $this->belongsToMany(Archive::class, 'magazine_order_archive')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
   
   
}
