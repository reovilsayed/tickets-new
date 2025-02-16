<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Events\OrderIsPaid;
use App\Http\Controllers\Controller;

class SendOrderSmsController extends Controller
{
    public function __invoke(Order $order)
    {
        $order->send_message = true;

        OrderIsPaid::dispatch($order);

        return redirect()->back()->with([
            'message'    => 'Message sent to user',
            'alert-type' => 'success',
        ]);
    }
}
