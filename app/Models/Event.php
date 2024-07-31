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
        return $this->hasMany(Product::class);
    }


    public function priceRange()
    {
        $prices = $this->products->map(fn ($product) => $product->currentPrice());
        return ['min' => $prices->min(), 'max' => $prices->max()];
    }

    public function getDateRange()
    {

        $startDate = $this->start_at;
        $endDate = $this->end_at;

        $arraySize = rand(1, $endDate->diffInDays($startDate));
        if ($arraySize != $endDate->diffInDays($startDate)) {
            $interval = $endDate->diffInDays($startDate) / $arraySize;
            $dates = [];
            for ($i = 0; $i < $arraySize; $i++) {
                $date = $startDate->copy()->addDays($interval * $i);
                $dates[] = $date->format('Y-m-d');
            }
            return $dates;
        } else {
            $period = CarbonPeriod::create($startDate, $endDate);
            $formattedDates = [];
            foreach ($period as $date) {
                $formattedDates[] = $date->format('Y-m-d');
            }

            return $formattedDates;
        }
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
}
