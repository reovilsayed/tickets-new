<?php

namespace App\Listeners;

use App\Events\OrderIsPaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Vemcogroup\SmsApi\SmsApi;

class SendMessageToCustomer
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderIsPaid $event): void
    {


        if ($event->order->send_message) {
            $message = 'Hello! Here is your page with your tickets and invoice! Please click here on the link: ' . route('digital-wallet', $event->order) . ' !!';
            SmsApi::send($event->order->billing->phone,  $message);
            Log::info($message);
        }
    }
}
