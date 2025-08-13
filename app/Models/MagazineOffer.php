<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagazineOffer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subscription()
    {
        return $this->belongsTo(SubscriptionMagazineDetail::class, 'subscription_magazine_details_id');
    }
    

    public function user(){
        return $this->belongsTo(User::class);
    }
}
