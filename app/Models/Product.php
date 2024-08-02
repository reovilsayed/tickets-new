<?php

namespace App\Models;

use App\City;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'expired_at' => 'datetime',
        'event_start_date' => 'datetime',
        'event_end_date' => 'datetime',
        'dates' => 'json'
    ];

    public function dates(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->datesArray()
        );
    }
    public function price(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }
    public function salePrice(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }

    public function discount()
    {
        $discount_amount  = $this->price - $this->sale_price;
        $discount_percantage = ($discount_amount / $this->price) * 100;
        return round($discount_percantage);
    }


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function currentPrice()
    {
        if ($this->sale_price) {
            return $this->sale_price;
        } else {
            return $this->price;
        }
    }

    protected function datesArray()
    {
        $period = CarbonPeriod::create($this->start_date, $this->end_date);
        $formattedDates = [];
        foreach ($period as $date) {
            $formattedDates[] = $date->format('Y-m-d');
        }

        return $formattedDates;
    }
}
