<?php

namespace App\Observers;

use App\Models\Extra;
use App\Services\TOCOnlineService;

class ExtraObserver
{
    /**
     * Handle the Extra "created" event.
     */
    public function created(Extra $extra): void
    {
        $tocOnline = new TOCOnlineService();

        $data = $tocOnline->createProduct(
            type: $extra->type,
            code: 'EXTRA_' . $extra->id,
            description: $extra->name,
            price: $extra->price,
            vat: true
        );
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
