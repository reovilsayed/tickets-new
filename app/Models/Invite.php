<?php

namespace App\Models;

use Error;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invite extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'used');
    }

    public function attachProducts(array $data)
    {
        try {
            DB::beginTransaction();
            foreach ($data as $id => $d) {
                $pivotQty = $this->products()->find($id)->pivot->quantity;
                if ($pivotQty > $d['quantity']) {
                    $product = Product::find($id);
                    $product->increment('quantity', $pivotQty - $d['quantity']);

                    $product->save();
                } elseif ($pivotQty < $d['quantity']) {
                    $product = Product::find($id);
                    $product->decrement('quantity',   $d['quantity'] - $pivotQty);
                    if ($product->quantity < 0) {
                        throw new Exception('Not enough quantity');
                    }
                    $product->save();
                }
            }
            $this->products()->sync($data);
            DB::commit();
        } catch (Exception | Error $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
