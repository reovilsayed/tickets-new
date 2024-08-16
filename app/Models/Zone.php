<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    
    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function scopeTicketZone($query){
        return $query->whereType(0);
    }
    public function scopeProductZone($query){
        return $query->whereType(1);
    }
}
