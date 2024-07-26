<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
     public function store(Request $request)  {
        $order=Order::find($request->order_id);
  
        Feedback::updateOrCreate(
            [
                'order_id'=>$request->order_id,
            ],[
            'order_id'=>$request->order_id,
            'shop_id'=>$order->shop_id,
            'feedback'=>$request->feedback,
        ]);
        return back()->with('success_msg','Feedback send suucessfully');
    }
    public function vendorFeedbacks() {
        $feedbacks=Feedback::where('shop_id',auth()->user()->shop->id)->latest()->get();
        return view('auth.seller.feedbacks',compact('feedbacks'));
    }
}
