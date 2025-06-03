<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function transactionable()
    {
        return $this->morphTo();
    }
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }
}
