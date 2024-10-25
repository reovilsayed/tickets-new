<?php

namespace App\Observers;

use App\Models\Order;
use App\Events\OrderIsPaid;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        // Check if payment_status is set to 1 on creation
        if ($order->payment_status === 1) {
            event(new OrderIsPaid($order));
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {       
        // Check if payment_status changed to 1 on update
        
        if ($order->isDirty('payment_status') && $order->payment_status == 1) {
            event(new OrderIsPaid($order));
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
