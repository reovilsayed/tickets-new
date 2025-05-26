<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'ticket_id',
        'zone_id',
        'user_id',
        'product_id',
        'name',
        'quantity',
        'used',
        'amount',
    ];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Extra::class, 'product_id');
    }
}
