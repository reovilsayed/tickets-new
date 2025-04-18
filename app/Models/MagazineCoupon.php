<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagazineCoupon extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function magazine()
    {
        return $this->belongsTo(Magazine::class);
    }

    public function isValid()
    {
        return $this->status &&
            now()->lte($this->expire_at) &&
            ($this->limit == 0 || $this->used < $this->limit);
    }

    public function incrementUsage()
    {
        $this->increment('used');
    }
}
