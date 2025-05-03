<?php

namespace App\Observers;

use App\Models\Extra;
use App\Services\TOCOnlineService;
use Illuminate\Support\Facades\Log;

class ExtraObserver
{
    /**
     * Handle the Extra "created" event.
     */
    public function created(Extra $extra): void
    {
        $tocOnline = new TOCOnlineService();
        $tax_type = $extra->tax_type;
        if ($tax_type == '23') {
            $tax_code = 'NOR';
        } else if ($tax_type == '13') {
            $tax_code = 'INT';
        } else {
            $tax_code = 'RED';
        }
        $data = $tocOnline->createProduct(
            type: $extra->type,
            code: 'EXTRA_' . $extra->id,
            description: $extra->name,
            price: $extra->price,
            vat: true,
            taxCode:$tax_code,
        );

        if (isset($data['error'])) {
            Log::error('TOCOnlineService: ' . $data['message']);
            return;
        }
        if (isset($data['data']['id'])) {
            $extra->update([
                'toconline_item_code' => 'EXTRA_' . $extra->id,
                'toconline_item_id' => $data['data']['id'],
            ]);
        } else {
            Log::error('TOCOnlineService: ' . json_encode($data));
        }
    }

    /**
     * Handle the Extra "updated" event.
     */
    public function updated(Extra $extra): void
    {
        //
    }

    /**
     * Handle the Extra "deleted" event.
     */
    public function deleted(Extra $extra): void
    {
        //
    }

    /**
     * Handle the Extra "restored" event.
     */
    public function restored(Extra $extra): void
    {
        //
    }

    /**
     * Handle the Extra "force deleted" event.
     */
    public function forceDeleted(Extra $extra): void
    {
        //
    }
}
