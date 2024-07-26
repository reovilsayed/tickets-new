<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdcatProduct extends Model
{
    use HasFactory;
    protected $table = 'prodcat_product';
    protected $fillable = ['product_id', 'prodcat_id'];
}
