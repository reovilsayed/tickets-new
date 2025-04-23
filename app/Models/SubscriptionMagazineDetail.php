<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionMagazineDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function magazine()
    {
        return $this->belongsTo(Magazine::class);
    }

    public function magazineSubscription()
    {
        return $this->belongsTo(MagazineSubscription::class, 'magazine_subscription_id');
    }
    public function subscription()
    {
        return $this->belongsTo(SubscriptionMagazineDetail::class, 'subscription_magazine_details_id');
    }
    public function subscriptionRecords()
    {
        return $this->hasMany(SubscriptionRecord::class, 'subscription_megazine_details_id');
    }

    public function needShipping()
    {
        if ($this->subscription_type == 'physical') {
            return true;
        } else {
            return false;
        }
    }

    public function totalShipment()
    {
        return $this->total_shipment;
    }
}
