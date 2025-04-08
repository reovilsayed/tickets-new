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
    // public function createSubscriptionRecords()
    // {
    //     foreach ($this->items as $item) {
    //         $details = json_decode($item->details, true);
    //         if (is_null($details)) {
    //             $details = json_decode($item->details, true);
    //         }
 
    //         SubscriptionRecord::create([
    //             'user_id' => $this->user_id,
    //             'magazine_subscription_id' => $details['magazine_subscription_id'] ?? null,
    //             'magazine_order_item_id' => $item->id,
    //             'magazine_id' => $details['magazine_id'] ?? null,
    //             'subscription_type' => $details['subscription_type'] ?? 'digital',
    //             'recurring_period' => $details['recurring_period'] ?? 'annual',
    //             'start_date' => now(),
    //             'end_date' => now()->addMonths($details['recurring_period'] == 'bi-annual' ? 6 : 12),
    //             'quantity' => $item->quantity,
    //             'price' => $item->unit_price,
    //             'total_price' => $item->unit_price * $item->quantity, 
    //             'status' => 'active',
    //         ]);
    //     }
    // }
}
