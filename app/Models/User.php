<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends \TCG\Voyager\Models\User implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasUlids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */


    protected $guarded = [];
    // protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function uniqueIds()
    {
        return ['uniqid'];
    }
    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }
    public function shopAddress()
    {
        return $this->hasOne(Address::class, 'user_id');
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function verification()
    {
        return $this->hasOne(Verification::class);
    }

    public function massages()
    {
        return $this->hasMany(Massage::class, 'reciver_id');
    }

    public function followedShops()
    {
        return $this->belongsToMany(Shop::class, 'shop_user', 'user_id', 'shop_id')->withTimestamps();
    }

    public function follows(Shop $shop)
    {
        return $this->followedShops()->where('shop_id', $shop->id)->exists();
    }

    public function chargeWithSubscription($amount, $comment)
    {
        return $this->invoiceFor(
            $comment,
            $amount
        );
    }

    public function getSubscription()
    {
        return $this->subscription('basic');
    }

    public function scans()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_user', 'user_id', 'ticket_id', 'id', 'id')->withPivot('action')->withTimestamps();
    }

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'ticket_user', 'user_id', 'zone_id', 'id', 'id')->withPivot('action')->withTimestamps();
    }

    public function subscriptionStatus()
{
    $subscription = $this->getSubscription();
    if (!$subscription || $subscription->stripe_status !== 'active' || $subscription->ends_at !== null) {
        return false;
    }
    return true;
}

    public function getCard()
    {
        return $this->defaultPaymentMethod();
    }

    public function cancelSubscription()
    {
        return $this->subscription('basic')->cancel();
    }

    public function cancelSubscriptionNow()
    {
        return $this->subscription('basic')->cancelNow();
    }


    public function resumeSubscription()
    {
        return $this->subscription('basic')->cancel();
    }


  
    public function isFollowingShop($shopId)
    {
        return $this->followedShops()->where('shop_id', $shopId)->exists();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function scopeFilter($query)
    {
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();

        return $query->whereHas('orders', function ($query) {
            $query->where('shop_id', auth()->user()->shop->id);
        })
            ->when(request('customers') == 2, function ($query) {
                $query->whereYear('created_at', '=', Carbon::now()->year);
            })
            ->when(request('customers') == 3, function ($query) {
                $query->where('created_at', Carbon::now());
            })
            ->when(request('customers') == 1, function ($query) use ($currentWeekStart, $currentWeekEnd) {
                $query->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd]);
            });
    }

    public function fullName()
    {
        return $this->name . ' ' . $this->l_name;
    }

    public function getCountry()
    {
        $country_array = config('countries');

        return $country_array[$this->country];
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'tickets');
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function pos()
    {
        return $this->belongsTo(Pos::class);
    }
    public function subscriptionRecords()
    {
        return $this->hasMany(SubscriptionRecord::class);
    }

    public function mymagazines(){
        return SubscriptionRecord::where('user_id', $this->id)
            ->where('subscription_type','digital')
            ->latest()
            ->select('magazine_id')->get()->pluck('magazine_id')->toArray();


    }

    
}
