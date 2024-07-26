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
	public function add(Request $request){
		
		if($request->variable_attribute){
			$variation = json_encode($request->variable_attribute);
		    $product = Product::where('parent_id',$request->product_id)->where('variation',$variation)->first();
			if(!$product){
				return back()->withErrors('Sorry! This variation no longer available');
			}
		}else{
			 $product = Product::find($request->product_id);
		}
		if($product->sale_price){
			$price = $product->sale_price;
		}else{
			$price = $product->price;
		}
		Cart::add($product->id, $product->name, $price,$request->quantity )->associate('App\Models\Product');
		//session()->flash('errors', collect(['Please Check Length,Width,Height,Weight again of this product']));
	    return redirect('/cart')->with('success_msg', 'Varen er blevet tilføjet til indkøbskurven!');
	}
    public function update(Request $request){
		Cart::update($request->product_id, array(
		'quantity' => array(
				  'relative' => false,
				  'value' => $request->quantity
			  ), 
		));
		return back()->with('success_msg', 'Item has been updated!');
	}
	public function destroy($id){
		Cart::remove($id);
		return back()->with('success_msg', 'Item has been removed!');
	}
}

