<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function magazine()
    {
        return $this->belongsTo(Magazine::class);
    }
    public function subscriptionRecords()
    {
        return $this->hasMany(SubscriptionRecord::class);
    }
}
