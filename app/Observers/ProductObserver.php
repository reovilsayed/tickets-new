<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\TOCOnlineService;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $tocOnline = new TOCOnlineService();
        $tax_type = $product->tax_type;
        if ($tax_type == '23') {
            $tax_code = 'NOR';
        } else if ($tax_type == '13') {
            $tax_code = 'INT';
        } else {
            $tax_code = 'RED';
        }
        $data = $tocOnline->createProduct(
            type: 'service',
            code: 'TICKET_' . $product->id,
            description: $product->name,
            price: $product->currentPrice(),
            vat: true,
            taxCode:$tax_code,
        );

        if (isset($data['error'])) {
            Log::error('TOCOnlineService: ' . $data['message']);
            return;
        }

        if (isset($data['data']['id'])) {
            $product->update([
                'toconline_item_code' => 'TICKET_' . $product->id,
                'toconline_item_id' => $data['data']['id'],
            ]);
        } else {
            Log::error('TOCOnlineService: ' . json_encode($data));
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
