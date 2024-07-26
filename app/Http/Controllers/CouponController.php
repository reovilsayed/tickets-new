<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use Cart;
use Session;

class CouponController extends Controller
{
	public function add(request $request)
	{
		$coupon = Coupon::where('code', $request->coupon_code)->first();

		if (!$coupon) {
			session()->flash('errors', collect(['Incorrect coupon code']));
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
		if (Cart::getSubTotal() < $coupon->minimum_cart) {
			session()->flash('errors', collect(['Minimum cart required to use this coupon ' . $coupon->minimum_cart]));
			return back();
		}
		Session::put('discount', $coupon->discount);
		Session::put('discount_code', $coupon->code);
		$coupon->increment('used');

		return back()->with('success_msg', 'Coupon has been applied successfully');
	}
	public function destroy()
	{
		session()->forget('discount');
		session()->forget('discount_code');
		return back()->with('success_msg', 'Coupon removed successfully');
	}
}
