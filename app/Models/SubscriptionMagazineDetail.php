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
        return $this->belongsTo(MagazineSubscription::class,);
    }

   
    
}
