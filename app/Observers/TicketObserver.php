<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Services\TOCOnlineService;
use Illuminate\Support\Facades\Log;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        $tocOnline = new TOCOnlineService();

        $data = $tocOnline->createProduct(
            type: 'service',
            code: 'TICKET_' . $ticket->id,
            description: $ticket->product->name,
            price: $ticket->price,
            vat: true
        );

        if (isset($data['error'])) {
            Log::error('TOCOnlineService: ' . $data['message']);
            return;
        }

        $ticket->update([
            'toconline_item_code' => 'TICKET_' . $ticket->id
        ]);
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
