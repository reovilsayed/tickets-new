<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function status()
    {

        if ($this->check_in_at && $this->check_out_at) {
            return 'Used';
        } elseif (now()->gt($this->product->event_end_date)) {
            return 'Expired';
        } else {
            return 'Not Used';
        }
    }
}
