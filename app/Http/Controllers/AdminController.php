<?php

namespace App\Http\Controllers;

use App\Mail\ShopWelcomeEmail;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function shopIndex()
    {
        $shops = Shop::latest()->get();
        return view('admin.shop.index', compact('shops'));
    }
    public function shopCreate()
    {
        $shop = new Shop();
        return view('admin.shop.create', compact('shop'));
    }
    public function shopStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'shop_name' => 'required',
            'logo' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',

        ]);
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
        $randomPassword = Str::random(12, $characters);
        $hashedPassword = Hash::make($randomPassword);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashedPassword,
            'role_id' => 3,
        ]);

        if ($request->has('cover')) {
            $cover = $request->cover->store('shop');
        } else {
            $cover = null;
        }
        $slug = Str::slug($request->shop_name);
        if (shop::where('slug', $slug)->first()) {
            $slug = $slug . '-' . $user->id;
        }
        Shop::create([
            'name' => $request->shop_name,
            'logo' => $request->logo->store('shop'),
            'banner' => $cover,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'slug' => $slug,
            'user_id' => $user->id,
            'status' => true,
        ]);
        Mail::to($user->email)->send(new ShopWelcomeEmail($user, $randomPassword));
        return redirect()->route('admin.shop.index')->with([
            'message'    => "Shop create Successfully",
            'alert-type' => 'success',
        ]);
    }
    public function shopEdit(Shop $shop)
    {

        return view('admin.shop.edit', compact('shop'));
    }
    public function shopUpdate(Shop $shop, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'shop_name' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',

        ]);
        $shop->user->update([
            'name' => $request->name,
        ]);
        if ($request->has('cover')) {
            if ($shop->banner && Storage::exists($shop->banner)) {
                Storage::delete($shop->banner);
                
            }
            $cover = $request->cover->store('shop');
        } else {
            $cover = $shop->banner;
        }
        if ($request->has('logo')) {
            if ($shop->logo && Storage::exists($shop->logo)) {
                Storage::delete($shop->logo);
                $logo = $request->logo->store('shop');
            }
        } else {
            $logo = $shop->logo;
        }
        $shop->update([
            'name' => $request->shop_name,
            'logo' => $logo,
            'banner' => $cover,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
        ]);
        return redirect()->route('admin.shop.index')->with([
            'message'    => "Shop Update Successfully",
            'alert-type' => 'success',
        ]);
    }
    public function shopDelete(Shop $shop) {
        if ($shop->logo && Storage::exists($shop->logo)) {
            Storage::delete($shop->logo);
        }
        if ($shop->banner && Storage::exists($shop->banner)) {
            Storage::delete($shop->logo);
        }
        // $shop->user->delete();
        $shop->delete();
        return redirect()->route('admin.shop.index')->with([
            'message'    => "Shop Delete Successfully",
            'alert-type' => 'success',
        ]);
    }
}
