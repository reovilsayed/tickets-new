<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function total(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }

    public function subtotal(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }

    public function tax(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }
    public function billing(): Attribute
    {

        return Attribute::make(
            set: fn ($value) => json_encode($value),
            get: fn ($value) => json_decode($value)
        );
    }

    public function discount(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value * 100,
            get: fn ($value) => $value / 100
        );
    }

    public function scopeFilter($query)
    {
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();

        return $query
            ->when(request('sales') == 2, function ($query) {
                $query->whereYear('created_at', '=', Carbon::now()->year);
            })
            ->when(request('sales') == 3, function ($query) {
                $query->where('created_at', Carbon::now());
            })
            ->when(request('sales') == 1, function ($query) use ($currentWeekStart, $currentWeekEnd) {
                $query->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd]);
            });
    }
    public function scopeCountFilter($query)
    {
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();

        return $query
            ->when(request('orders') == 2, function ($query) {
                $query->whereYear('created_at', '=', Carbon::now()->year);
            })
            ->when(request('orders') == 3, function ($query) {
                $query->where('created_at', Carbon::now());
            })
            ->when(request('orders') == 1, function ($query) use ($currentWeekStart, $currentWeekEnd) {
                $query->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd]);
            });
    }

    
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
