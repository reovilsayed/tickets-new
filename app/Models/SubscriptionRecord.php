<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRecord extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts   = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'is_offer'   => 'boolean',
    ];
    // const STATUS_ACTIVE = 'active';
    // const STATUS_EXPIRED = 'expired';
    // const STATUS_CANCELLED = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function magazine()
    {
        return $this->belongsTo(Magazine::class);
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
        return $this->belongsTo(MagazineOrder::class, 'magazine_order_id');
    }
    public function getDetailsAttribute($value)
    {

        return json_decode($value, true);
    }
    public function scopeOffer($query)
    {
        return $query->where('is_offer', 1);
    }

    /**
     * Scope for paid records (is_offer = 0)
     */
    public function scopePaid($query)
    {
        return $query->where('is_offer', 0);
    }
    

}
