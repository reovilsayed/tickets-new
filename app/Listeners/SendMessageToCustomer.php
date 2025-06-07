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
                $event->order->load('event');

                $eventName = $event->order->event?->name ?? 'Essência do Vinho - Lisboa';
                $event_id = $event->order->event?->id;

                $message = 'Informação e Acesso ao ' . $eventName . ' : aceda aqui  [%goto:' . route('digital-wallet', ['uniqid' => $event->order->user->uniqid, 'event_id' => $event_id]) . '%] !!';
                SmsApi::send($event->order->billing->phone,  $message);
                Log::info($message);
            }
        } catch (Exception | Error $e) {
        }
    }
}
