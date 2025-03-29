<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagazineOrderArchive extends Model
{
    use HasFactory;
    protected $table = 'magazine_order_archive';
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(MagazineOrder::class, 'magazine_order_id');
    }

}
