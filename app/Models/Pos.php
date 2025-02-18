<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $defaultPermission = [
        "tickets" => 0,
        "extras" => 0,
        "scan" => 0,
        "report" => 0,
    ];


    public function permission(): Attribute
    {
        return Attribute::make(
            get: fn() => @$this->attributes['permission'] ? json_decode($this->attributes['permission'], true) : $this->defaultPermission,
            set: function ($value) {

                return json_encode(array_merge($this->defaultPermission, $value));
            }
        );
    }
}
