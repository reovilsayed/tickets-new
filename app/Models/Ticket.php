<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'dates' => 'json'
    ];
    public function dates(): Attribute
    {
        return Attribute::make(
            set: fn($value) => json_encode($value),
            get: fn($value) => json_decode($value)
        );
    }
    public function owner(): Attribute
    {
        return Attribute::make(
            set: fn($value) => json_encode($value),
            get: fn($value) => json_decode($value)
        );
    }
    public function logs(): Attribute
    {
        return Attribute::make(
            set: fn($value) => json_encode($value),
            get: fn($value) => $value ? json_decode($value, true) : []
        );
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function status()
    {
        switch ($this->status) {
            case 1:
                return 'Checked In';
            case 2:
                return 'Checked Out';
            case 3:
                return 'Expired';
            default:
                return 'Pending';
        }
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

    public function scanedBy()
    {
        return $this->belongsToMany(User::class, 'ticket_user', 'ticket_id', 'user_id', 'id', 'id')->withPivot('action', 'zone_id')->withTimestamps();
    }
    // protected static function booted(): void
    // {
    //     static::addGlobalScope('validTicket', function (Builder $builder) {
    //         $builder->whereIn('type', ['physical', 'invite'])->orWhereHas('order', function ($order) {
    //             $order->where('status', 1)->where('payment_status', 1);
    //         });
    //     });
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function checkIn()
    {
        return $this->belongsTo(Zone::class, 'check_in_zone');
    }
    public function checkOut()
    {
        return $this->belongsTo(Zone::class, 'check_out_zone');
    }


    public function getBsStatusClass()
    {

        switch ($this->status) {
            case 0:
                return 'secondary';
            case 1:
                return 'success';
            case 2:
                return 'success';
            case 3:
                return 'danger';
            default:
                return 'secondary';
        }
    }
}
