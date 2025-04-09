<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRecord extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function magazine()
    {
        return $this->belongsTo(Magazine::class);
    }

    public function magazineSubscription()
    {
        return $this->belongsTo(MagazineSubscription::class);
    }

    public function magazineOrderItem()
    {
        return $this->belongsTo(MagazineOrderItem::class);
    }
}
