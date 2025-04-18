<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Event;
use App\Models\Magazine;
use App\Models\MagazineCoupon;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use Cart;
use Session;

class CouponController extends Controller
{
	public function add(request $request, Event $event)
	{

		$coupon = Coupon::where('code', $request->coupon_code)->first();

		if (!$coupon) return redirect()->back()->withErrors(['Invalid coupon']);
		$discount = $coupon->discount;
		if (!$coupon) {
			session()->flash('errors', collect(['Incorrect coupon code']));
			return back();
		}

		if ($event->id != $coupon->event_id) {
			session()->flash('errors', collect(['This coupon is not valid for the selected event']));
			return back();
		}

		// Example: Check if any product in the cart matches the coupon's associated products
		$products = $coupon->products;

		$cartItems = Cart::session($event->slug)->getContent();
		$productMatch = false;

		foreach ($cartItems as $item) {

			if ($products->contains('id', $item->id)) {
				$productMatch = true;
				break;
			}
		}
		if (!$productMatch) {
			session()->flash('errors', collect(['This coupon is not valid for the selected product']));
			return back();
		}

		if (Carbon::create($coupon->expire_at) < now()) {
			session()->flash('errors', collect(['Coupon has been expired']));
			return back();
		}
		if ($coupon->limit <= $coupon->used) {
			session()->flash('errors', collect(['Coupon has been expired']));
			return back();
		}
		// if (Cart::session($event->slug)->getTotal() < $coupon->minimum_cart) {
		// 	session()->flash('errors', collect(['Minimum cart required to use this coupon ' . $coupon->minimum_cart]));
		// 	return back();
		// }
		if ($coupon->type == 'percentage') {
			$total = Cart::session($event->slug)->getContent()->filter(
				function ($item) use ($coupon) {
					return $coupon->getProducts()->contains($item->id);
				}
			)->map(fn($cart) => $cart->quantity * $cart->price)->sum();

			$discount = ($coupon->discount / 100) * $total;
		}

		Session::put('discount', $discount);
		Session::put('discount_code', $coupon->code);


		return back()->with('success_msg', 'Coupon has been applied successfully');
	}
	public function destroy()
	{
		session()->forget('discount');
		session()->forget('discount_code');
		return back()->with('success_msg', 'Coupon removed successfully');
	}

	public function applyCoupon(Request $request, Magazine $magazine)
	{
		$request->validate(['coupon_code' => 'required|string']);

		$coupon = MagazineCoupon::where('code', $request->coupon_code)
			->where('magazine_id', $magazine->id)
			->where('status', true)
			->where('expire_at', '>=', now())
			->where(function ($query) {
				$query->where('limit', 0)
					->orWhereRaw('used < limit');
			})
			->first();

		if (!$coupon) {
			return back()->with('error', __('words.invalid_or_expired_coupon'));
		}

		$cartTotal = Cart::session($magazine->slug)->getTotal();

		// Apply fixed discount
		$discount = min($coupon->discount, $cartTotal);

		// Increment usage
		$coupon->increment('used');

		session([
			'discount' => $discount,
			'discount_code' => $coupon->code,
			'coupon_id' => $coupon->id
		]);

		return back()->with('success', __('words.coupon_applied_success'));
	}

	public function removeCoupon(Magazine $magazine)
	{
		if (session('coupon_id')) {
			MagazineCoupon::where('id', session('coupon_id'))->decrement('used');
		}

		session()->forget(['discount', 'discount_code', 'coupon_id']);
		return back()->with('success', __('words.coupon_removed'));
	}
}
