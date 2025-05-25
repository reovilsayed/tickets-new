<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function zones(): Attribute
    {
        return Attribute::make(
            set: fn($value) => json_encode($value),
            get: fn($value) => json_decode($value, true) ?? [],
        );
    }

    public function poses()
    {
        return $this->belongsToMany(Pos::class, 'extra_pos', 'extra_id', 'pos_id');
    }
    public function category()
    {
        return $this->belongsTo(ExtraCategory::class, 'extra_category_id');
    }
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function extraCategory()
    {
        return $this->belongsTo(ExtraCategory::class,'extras_category_id');
    }

}
