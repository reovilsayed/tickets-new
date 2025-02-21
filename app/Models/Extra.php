<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Facades\Voyager;

class Extra extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function zones(): Attribute
    {
        return Attribute::make(
            set: fn($value) => json_encode($value),
            get: fn($value) => json_decode($value,true) ?? [],
        );
    }
    public function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Voyager::image($this->attributes['thumbnail']),
        );
    }

    public function poses()
    {
        return $this->belongsToMany(Pos::class, 'extra_pos', 'extra_id', 'pos_id');
    }
}
