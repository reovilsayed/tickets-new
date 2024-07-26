<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Cart;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add()
    {

        $wishlist = session()->get('wishlist', []);
        if (in_array(request()->productId, $wishlist)) {
            $wishlist = array_values(array_diff($wishlist, [request()->productId]));
            session()->put('wishlist', $wishlist);
        } else {
            $wishlist[] = request()->productId;
            session()->put('wishlist', $wishlist);
        }

        // if (!in_array(request()->productId, $wishlist)) {
        //     $wishlist[] = request()->productId;
        //     session()->put('wishlist', $wishlist);
        // }

        return redirect()->back()->with('success_msg', 'Item added to wishlist.');
    }

    public function remove($productId)
    {
        $wishlist = session()->get('wishlist', []);

        if (in_array($productId, $wishlist)) {
            $wishlist = array_values(array_diff($wishlist, [$productId]));
            session()->put('wishlist', $wishlist);
        }

        return redirect()->back()->with('success_msg', 'Item removed from wishlist.');
    }

    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        $products = Product::whereIn('id', $wishlist)->get();

        return view('pages.wishlist', compact('products'));
    }

    public function wishlistToCart(Request $request)
    {
        $product = Product::find($request->product_id);
        if ($product->saleprice) {
            $price = $product->saleprice;
        } else {
            $price = $product->price;
        }
        Cart::add($product->id, $product->name, $price, 1)->associate('App\Models\Product');
        $this->remove(request('product_id'));
        return back()->with('success_msg', 'Item has been moved to cart');
    }
}
