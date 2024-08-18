<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('quantity','used');
    }
}
