<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invite;
use App\Models\Magazine;
use App\Models\Offer;
use Illuminate\Http\Request;
use Cart;
use App\Models\Product;
use Darryldecode\Cart\Cart as CartCart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
	public function add(Event $event, Request $request)
	{

		Cart::session($event->slug)->clear();
		session()->forget('discount');
		session()->forget('discount_code');
		foreach ($request->tickets as $ticket => $quantity) {
			if ($quantity > 0) {
				$product = Product::find($ticket);
				Cart::session($event->slug)->add($product->id, $product->name, $product->currentPrice(), $quantity)->associate('App\Models\Product');
			}
		}
		return redirect()->route('checkout', $event);
	}
	public function magazineAdd(Magazine $magazine, Request $request)
	{

		
	
		return redirect()->route('magazine_checkout', $magazine);
	}
	public function inviteadd(Invite $invite, Request $request)
	{

		Cart::session($invite->slug)->clear();
		foreach ($request->tickets as $ticket => $quantity) {
			if ($quantity > 0) {
				$product = Product::find($ticket);
				Cart::session($invite->slug)->add($product->id, $product->name, 0, $quantity)->associate('App\Models\Product');
			}
		}
		return redirect()->route('invitecheckout', $invite);
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
