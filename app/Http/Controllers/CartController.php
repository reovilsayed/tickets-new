<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Cart;
use App\Models\Product;
use Darryldecode\Cart\Cart as CartCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
	public function add(Request $request)
	{
		$event_slug = request('event_slug');
		Cart::clear();
		$allQuantitiesZero = true;
		foreach ($request->tickets as $quantity) {
			if ($quantity > 0) {
				$allQuantitiesZero = false;
				break;
			}
		}

		if ($allQuantitiesZero) {
			return redirect()->back()->withErrors(['error' => 'At least one ticket quantity must be greater than zero.']);
		}
		foreach ($request->tickets as $ticket => $quantity) {
			if($quantity > 0){
				$product = Product::find($ticket);
				Cart::add($product->id, $product->name, $product->currentPrice(), $quantity)->associate('App\Models\Product');
			}
		}
		return redirect()->route('checkout',['event'=>$event_slug])->with('success_msg', 'Varen er blevet tilføjet til indkøbskurven!');
	}
	public function update(Request $request)
	{
		Cart::update($request->product_id, array(
			'quantity' => array(
				'relative' => false,
				'value' => $request->quantity
			),
		));
		return back()->with('success_msg', 'Item has been updated!');
	}
	public function destroy($id)
	{
		Cart::remove($id);
		return back()->with('success_msg', 'Item has been removed!');
	}
}
