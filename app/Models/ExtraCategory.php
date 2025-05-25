<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraCategory extends Model
{
    use HasFactory;

    protected $table = 'extra_categories';  
    protected $order_column = 'order';
    
    protected $fillable = ['name', 'slug', 'order'];

    public function extras()
    {
        return $this->hasMany(Extra::class, 'extra_category_id');
    }
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
