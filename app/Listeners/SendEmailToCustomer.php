<?php

namespace App\Listeners;

use App\Events\OrderIsPaid;
use App\Mail\InviteDownload;
use App\Mail\TicketDownload;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailToCustomer
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

        $order = $event->order;
        Log::info('order event ' . $event->order->id);
   
        if ($order->send_email) {

            $products = $order->tickets->groupBy('product_id');
            foreach ($products as $key => $tickets) {
                $product = Product::find($key);

                if ($order->user) {
                    Mail::to($order->user->email)->send(new TicketDownload($order, $product, null));
                } else {

                    if ($order->payment_method == 'invite') {

                        Mail::to($order->user->email)->send(new InviteDownload($order, $product, null));
                    } else {
                        Mail::to($order->user->email)->send(new TicketDownload($order, $product, null));
                    }
                }
            }
        }
    }
}
