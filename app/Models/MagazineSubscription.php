<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagazineSubscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function magazine()
    {
        return $this->belongsTo(Magazine::class ,'magazine_id');
    }
    public function subscriptionMagazineDetails()
    {
        return $this->belongsToMany(SubscriptionMagazineDetail::class,'magazine_subscription_id', 'subscription_magazine_detail_id');
    }
    
}
