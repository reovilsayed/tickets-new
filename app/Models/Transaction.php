<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope('withTransactionable', function (Builder $builder) {
            $builder->whereHas('transactionable');
        });
    }

    public function transactionalbe()
    {
        return $this->morphTo();
    }
}
