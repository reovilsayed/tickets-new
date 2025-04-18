<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    // const STATUS_ACTIVE = 'active';
    // const STATUS_EXPIRED = 'expired';
    // const STATUS_CANCELLED = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function subscriptionMagazineDetail()
    {
        return $this->belongsTo(SubscriptionMagazineDetail::class, 'subscription_megazine_details_id');
    }

    public function magazineOrder()
    {
        return $this->belongsTo(MagazineOrder::class, 'magazine_orders_id');
    }
}
