<?php

namespace App\Listeners;

use App\Events\OrderIsPaid;
use Error;
use Exception;
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


        try {

            if ($event->order->send_message) {
                $message = '"Informação e Acesso ao Essência do Vinho - Lisboa : aceda aqui  [%goto:' . route('digital-wallet', $event->order->user) . '%] !!';
                SmsApi::send($event->order->billing->phone,  $message);
                Log::info($message);
            }
        } catch (Exception | Error $e) {
        }
    }
}
