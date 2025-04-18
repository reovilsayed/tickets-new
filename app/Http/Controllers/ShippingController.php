<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function getPrice(Request $request)
    {
        $country = $request->get('country');
    
        $shipping = \App\Models\Shipping::where('country', $country)->first();
    
        return response()->json([
            'price' => $shipping?->price ?? null
        ]);
    }
}
