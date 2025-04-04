<?php

namespace App\Models;

use App\City;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'expired_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'dates' => 'json',
        'one_time' => 'boolean',
        'check_in' => 'boolean',
    ];

    public function dates(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->datesArray()
        );
    }

    public function zones(): Attribute
    {
        return Attribute::make(
            set: fn($value) => json_encode($value),
            get: fn($value) => $value ? collect(json_decode($value, true))->map(fn($id) => Zone::find($id)) : collect([])
        );
    }

    public function poses()
    {
        return $this->belongsToMany(Pos::class, 'product_pos', 'product_id', 'pos_id');
    }
    public function extras(): Attribute
    {
        return Attribute::make(
            set: fn($value) => json_encode($value),
            get: fn($value) => json_decode($value, true) ?? []
        );
    }
    public function price(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value * 100,
            get: fn($value) => $value / 100
        );
    }
    public function salePrice(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value * 100,
            get: fn($value) => $value / 100
        );
    }

    public function tax(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value * 100,
            get: fn($value) => $value / 100
        );
    }

    public function secondaryTax(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value * 100,
            get: fn($value) => $value / 100
        );
    }

    public function secondaryTaxPercentage(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value * 100,
            get: fn($value) => $value / 100
        );
    }

    public function tartiaryTax(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value * 100,
            get: fn($value) => $value / 100
        );
    }

    public function tartiaryTaxPercentage(): Attribute
    {
        return Attribute::make(
            set: fn($value) => $value * 100,
            get: fn($value) => $value / 100
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
    public function totalTax()
    {
        $price = $this->price;
        $totalTax = 0;
        if (!is_null($this->tartiary_tax_percentage) && !is_null($this->tartiary_tax)) {
            $tartiaryTaxBase = $price * ($this->tartiary_tax_percentage / 100);
            $tartiaryTax = $tartiaryTaxBase * ($this->tartiary_tax / 100);
            $totalTax += $tartiaryTax;
            $price -= $tartiaryTaxBase;
        }
        if (!is_null($this->secondary_tax_percentage) && !is_null($this->secondary_tax)) {
            $secondaryTaxBase = $price * ($this->secondary_tax_percentage / 100);
            $secondaryTax = $secondaryTaxBase * ($this->secondary_tax / 100);
            $totalTax += $secondaryTax;
            $price -= $secondaryTaxBase;
        }
        $regularTax = $price * ($this->tax / 100);
        $totalTax += $regularTax;

        return $totalTax;
    }
    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($product) {
    //         $product->generateDates();
    //     });

    //     static::updating(function ($product) {
    //         $product->generateDates();
    //     });
    // }

    public function generateDates()
    {
        if ($this->start_date && $this->end_date) {
            $dates = [];
            $currentDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);

            while ($currentDate->lessThanOrEqualTo($endDate)) {
                $dates[] = $currentDate->toDateString();
                $currentDate->addDay();
            }

            $this->dates = $dates;
        }
    }
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupons_product');
    }

    public function physicalTickets()
    {
        return $this->hasMany(Ticket::class, 'product_id')->where('type', 'physical');
    }
}
