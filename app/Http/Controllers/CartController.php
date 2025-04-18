<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\Event;
use App\Models\Invite;
use App\Models\Magazine;
use App\Models\MagazineSubscription;
use App\Models\Offer;
use Illuminate\Http\Request;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\Product;
use App\Models\SubscriptionMagazineDetail;
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


		Cart::session($magazine->slug)->clear();
		session()->forget(['discount', 'discount_code', 'coupon_id']);
		if ($request->has('archive')) {
			foreach ($request->archive as $archive => $quantity) {
				if ($quantity > 0) {
					$archive = Archive::find($archive);
					Cart::session($magazine->slug)->add($archive->id, $archive->title, $archive->price, $quantity, ['type' => 'onetime'])->associate('App\Models\Archive');
				}
			}
		}

		if ($request->has('subscription')) {
			$subscriptionData = $request->subscription;

	
			if (!empty($subscriptionData['annual'])) {
				$subscription = SubscriptionMagazineDetail::find($subscriptionData['annual']);

				if ($subscription) {
					Cart::session($magazine->slug)->add(
						$subscription->id,
						ucfirst($subscription->subscription_type) . ' (' . ucfirst($subscription->recurring_period) . ') Subscription',
						$subscription->price,
						1,
						[
							'type' => 'subscription',
							'subscription_type' => $subscription->subscription_type,
							'subscription' => $subscription->recurring_period,
						]
					)->associate('App\Models\SubscriptionMagazineDetail');
				}
			}

			if (!empty($subscriptionData['biannual'])) {
				$subscription = SubscriptionMagazineDetail::find($subscriptionData['biannual']);

				if ($subscription) {
					Cart::session($magazine->slug)->add(
						$subscription->id,
						ucfirst($subscription->subscription_type) . ' (' . ucfirst($subscription->recurring_period) . ') Subscription',
						$subscription->price,
						1, 
						[
							'type' => 'subscription',
							'subscription_type' => $subscription->subscription_type,
							'subscription' => $subscription->recurring_period,
						]
					)->associate('App\Models\SubscriptionMagazineDetail');
				}
			}
		}

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
