<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagazineOffer extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts   = [
        'shipping_info' => 'array',
    ];

    public function subscription()
    {
        return $this->belongsTo(SubscriptionMagazineDetail::class, 'subscription_magazine_details_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function shippingInfo() : Attribute
    {
        return Attribute::make(
            
            set: fn ($value) => ! empty($value) ? json_encode($value) : null
        );
    }

}
