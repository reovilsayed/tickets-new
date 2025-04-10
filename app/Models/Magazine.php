<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function path(): string
    {
        return route('magazines.show', $this);
    }
    public function archives()
    {
        return $this->hasMany(Archive::class, 'magazine_id');
    }
    public function magazineOrders()
    {
        return $this->belongsToMany(MagazineOrder::class, 'magazine_order_archive')->withPivot(['quantity', 'price']);
    }
    public function subscriptions()
    {
        return $this->hasMany(SubscriptionMagazineDetail::class, 'magazine_id');
    }

    public function biAnnualSubscriptions()
    {
        return $this->hasMany(SubscriptionMagazineDetail::class, 'magazine_id')->where('recurring_period', 'bi-annual');
    }
    public function annualSubscriptions()
    {
        return $this->hasMany(SubscriptionMagazineDetail::class, 'magazine_id')->where('recurring_period', 'annual');
    }
    public function getStatusTextAttribute()
    {
        return $this->status == 1 ? 'active' : 'inactive';
    }
}
