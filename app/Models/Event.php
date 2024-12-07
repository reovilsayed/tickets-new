<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];
    public function path()
    {
        return route('product_details', $this->slug);
    }

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('sequence', 'asc');
    }
    public function extras()
    {
        return $this->hasMany(Extra::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function invites()
    {
        return $this->hasMany(Invite::class);
    }
    public function posTickets()
    {
        return $this->hasMany(Ticket::class)->whereNotNull('pos_id')->where('type', 'paid');
    }
    public function digitalTickets()
    {
        return $this->hasMany(Ticket::class)->whereNull('pos_id')->where('type', 'paid');
    }
    public function inviteTickets()
    {
        return $this->hasMany(Ticket::class)->where('type', 'invite');
    }
    public function physicalTickets()
    {
        return $this->hasMany(Ticket::class)->where('type', 'physical');
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }


    public function priceRange()
    {
        $prices = $this->products()->where('status', 1)->where('invite_only',0)->get()->map(fn($product) => $product->currentPrice());
        return ['min' => $prices->min(), 'max' => $prices->max()];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function dates()
    {
        $period = CarbonPeriod::create($this->start_at, $this->end_at);
        $formattedDates = [];
        foreach ($period as $date) {
            $formattedDates[] = $date->format('Y-m-d');
        }

        return $formattedDates;
    }
    public function coupons()
    {
        return $this->hasToMany(Coupon::class);
    }
}
