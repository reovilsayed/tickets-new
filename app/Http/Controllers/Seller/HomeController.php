<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Error;
use Exception;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function ticketCheck(Request $request) {
    try {
        $order=Order::where('order_number', $request->ticket_search)->first();
        if($order){
            return redirect()->route('vendor.orderView', $request->ticket_search)
            ->with('success_msg', 'Ticket is Fined');
        }else{
            return redirect()->back()->withErrors("Ticket doesn't match");
        }
    }  catch (Exception $e) {
        return redirect()->back()->withErrors($e);
    } catch (Error $e) {
        return redirect()->back()->withErrors($e);
    }
 
   }
   function ticketUpdate(Order $order) {
           $order->update([
            'status' => 1,
        ]);
        return redirect()->route('vendor.ordersIndex')
        ->with('success_msg', 'Ticket is fulfill');
   }
}
