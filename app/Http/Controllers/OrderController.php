<?php
namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function unmark(Order $order)
    {
        $order->alert = 'unmarked';
        $order->save();

        return redirect()->back()->with('success', 'Order marked as unmarked.');
    }
}
