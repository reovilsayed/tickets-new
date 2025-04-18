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
    public function subscriptionRecords()
    {
        return $this->hasMany(SubscriptionRecord::class, 'magazine_orders_id');
    }
    public function magazine()
    {
        return $this->belongsTo(Magazine::class);
    }
    public function createSubscriptionRecords()
    {
        foreach ($this->items as $item) {
            $details = json_decode($item->details, true);

            SubscriptionRecord::create([
                'user_id' => $this->user_id,
                'magazine_order_id' => $item->id,
                'magazine_order_item_id' => $item->id,
                'type' => $details['type'] ?? '',
                'subscription_type' => $details['subscription_type'] ?? 'digital',
                'recurring_period' => $details['recurring_period'] ?? null,
                'start_date' => now(),
                'end_date' => now()->addMonths((int) ($details['recurring_period'] ?? 0)),
                'details' => json_encode($details),
            ]);
        }

        return back();
    }

    public function appliedCoupon()
    {
        return $this->belongsTo(MagazineCoupon::class, 'discount_code', 'id');
    }
}
