<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmail;
use App\Models\Address;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function update_profile()
    {
        return view('auth.user.profile_edit');
    }
    public function profileUpdate(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'max:40'],
            'last_name' => ['required', 'max:40'],
            'email' => ['required', 'max:40'],
            // 'contact_number' => ['required', 'max:200'],

            // 'avatar' => ['nullable','mimes:jpg,png,jpeg,gif'],
        ]);
        
        if ($request->has('avatar')) {                          //If any image is uploaded

            if (Storage::exists(auth()->user()->avatar)) {
                Storage::delete(auth()->user()->avatar);
            }

            $avatar = $request->avatar->store('users');
        } else {                                   //if nothing is uploaded

            $avatar = auth()->user()->avatar;
        }
        $phone = auth()->user();
        $phone->createMetas($request->meta);
        auth()->user()->update([

            'name' => $request->first_name,
            'l_name' => $request->last_name,

            'email' => $request->email,
            'avatar' => $avatar,

        ]);
        // auth()->user()->addresses()->updateOrCreate(['user_id' => auth()->id()], [

        //     'phone' => $request->contact_number,



        // ]);
        return redirect()->route('user.dashboard')->with('success_msg', 'Profile updated successfully!');
    }


    public function addressupdate(Request $request)
    {
        $request->validate([

            'post_code' => ['required', 'max:10'],
            'state' => ['required', 'max:20'],
            'city' => ['required', 'max:50'],
            'country' => ['nullable', 'max:50'],
            'address_1' => ['required', 'max:200'],
            'address_2' => ['required', 'max:200'],

            // 'avatar' => ['nullable','mimes:jpg,png,jpeg,gif'],
        ]);

        auth()->user()->addresses()->updateOrCreate(['user_id' => auth()->id()], [

            'post_code' => $request->post_code,
            'state' => $request->state,
            'city' => $request->city,
            'country' => $request->country,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,

        ]);
        return redirect()->route('user.dashboard')->with('success_msg', 'updated successfully!');
    }
    //-----order showing & filtering----start//
    public function ordersIndex(Request $request)
    {

        $latest_orders = Order::where('user_id', auth()->user()->id)
            ->whereNotNull('parent_id')
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })->latest()->get();
        // $past_orders = Order::where('user_id', auth()->user()->id)->where('status',1)->latest()->get();

        return view('auth.user.order.index', compact('latest_orders'));
    }
    //-----order showing & filtering---- end//
    public function invoice(Order $order)
    {
        return view('auth.user.order.invoice', compact('order'));
    }
    public function order_cancel(Order $order)
    {

        // if($order->status == 1) abort(403);
        // if(auth()->user()->id != $order->user_id) abort(403);

        $order->status = 3;

        $order->save();
        return redirect()->back();
    }
    public function change_password()
    {
        return view('auth.user.change_password');
    }

    public function update_password(Request $request)
    {

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new-password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success_msg', 'Password changed successfully');
    }
    public function offers()
    {
        $offers = Offer::where('user_id', auth()->id())->latest()->get();
        return view('auth.user.offers', compact('offers'));
    }
    public function becomeSeller()
    {
        $user = auth()->user();
        $verify_token = Str::random(20);
        if ($user->role_id !== 3) {

            $user->update([
                'role_id' => 3,
            ]);
            Mail::to($user->email)->send(new VerifyEmail($user, $verify_token));
            return redirect('/verify-email');
        }
        return redirect()->back()->withErrors('You have Already request');
    }
    public function removeCard(Request $request)
    {
        auth()->user()->deletePaymentMethod($request->method);
        return redirect()->back();
    }
    public function setCardAsDefault(Request $request)
    {
        auth()->user()->updateDefaultPaymentMethod($request->method);
        return redirect()->back();
    }
}
