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


    protected $defaultPaymentMethods = [
        "card" => 0,
        "qr" => 0,
        "cash" => 0,
    ];


    public function permission(): Attribute
    {
        return Attribute::make(
            get: fn() => @$this->attributes['permission'] ? array_merge($this->defaultPermission,   @json_decode($this->attributes['permission'], true) ?? [])  : $this->defaultPermission,
            set: function ($value) {

                return json_encode(array_merge($this->defaultPermission, $value));
            }
        );
    }
    
    public function paymentmethods(): Attribute
    {
        return Attribute::make(
            get: function () {
                $methods = $this->attributes['payment_methods'] ?? null;
                return $methods ? array_merge($this->defaultPaymentMethods, json_decode($methods, true) ?? []) : $this->defaultPaymentMethods;
            },
            set: function ($value) {
               
                return json_encode(array_merge($this->defaultPaymentMethods, $value ?? []));
            }
        );
    }
}
