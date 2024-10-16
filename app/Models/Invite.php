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
        DB::beginTransaction();

        try {
            foreach ($data as $id => $d) {
                $product = Product::find($id);
                if (!$product) {
                    throw new Exception('Product not found');
                }
                $pivotProduct = $this->products()->find($id);
                $pivotQty = $pivotProduct ? $pivotProduct->pivot->quantity : 0;
                $quantityDifference = $pivotQty - $d['quantity'];
                if ($quantityDifference > 0) {
                    // Return quantity to the stock
                    $product->increment('quantity', $quantityDifference);
                } elseif ($quantityDifference < 0) {
                    // Decrease quantity from stock
                    $product->decrement('quantity', abs($quantityDifference));
                    if ($product->quantity < 0) {
                        throw new Exception('Not enough quantity');
                    }
                }
                // Save only if there was a change
                if ($quantityDifference !== 0) {
                    $product->save();
                }
            }
            // Sync products with quantities
            $this->products()->sync($data);
            DB::commit();
        } catch (Exception | Error $e) {
            DB::rollBack();
            throw $e;  // Log or handle exception as needed
        }
    }
}
