<?php

namespace App\Http\Controllers\Seller;

use App\City;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Notification;
use App\Models\Prodcat;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function products()
    {
        $query = Product::where('shop_id', Auth()->user()->shop->id)->whereNull('parent_id');

        if (request()->filled('search')) {

            $query->where('short_description', 'LIKE', '%' . request()->search . '%');
        };

        $products = $query->latest()->paginate(20);
        return view('auth.seller.product.index', compact('products'));
    }
    public function create()
    {


        $prodcats = Prodcat::with('childrens')->where('parent_id', null)->get();
        $cities=City::all();

        return view('auth.seller.product.create', compact('prodcats','cities'));
    }
    public function store(Request $request)
    {
        $uniqueId = Str::uuid()->toString(8);
        $sku = substr($uniqueId, 0, 10);
        $data = $request->validate(
            [
                "name"          => "required|max:200",
                "categories"  => "nullable",

                "price"         => "required|regex:/^\\d*(\\.\\d{1,2})?$/",
                "sale_price"     => "nullable|regex:/^\\d*(\\.\\d{1,2})?$/",


                "quantity"      => "required|integer",
                "description"   => "required",
                "short_description"   => "required",

                "image"         => "required|mimes:jpg,jpeg,png",
                "images.*"      => "mimes:jpg,jpeg,png",

                "dimensions"    => "nullable",
                "weight"        => "nullable",
                "vendor_price"  => "nullable",
                "post_code" => "nullable",
                "options" => "nullable",
                "sizes" => "nullable",
                "color" => "nullable",
                "is_variable_product"=>"nullable",
                "amenities"=>"required",
                "expired_at"=>"required",
                "city_id"=>"required",


            ]
        );
        if($request->sale_price){
            if($request->price > $request->sale_price){
                $data['sale_price']=$request->sale_price;
            }else{
                return redirect()->back()->withErrors('sale-price greater than price');
            }
        }
    
        if ($request->file('image')) {
            $data['image'] = $request->image->store("products");
        }

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $imgs[] = $img->store("products");
            }

            $data['images'] = json_encode($imgs);
        }


        unset($data['categories']);

        // dd($product->prodcats());

        $data['shop_id'] = auth()->user()->shop ? auth()->user()->shop->id : null;
        $data['is_offer'] = $request->offer;


        $data['sku'] = $sku;
        $product = Product::create($data);
        $product->prodcats()->attach($request->categories);

        $slug = Str::slug($product->name);
        if (Product::where('slug', $slug)->first()) {
            $slug = $slug . '-' . $product->id;
        }
        $product->update([
            'slug' =>  $slug,
        ]);

        // foreach (Auth()->user()->shop->followers as $follower) {
        //     $this->notification($follower->id, null, $slug);
        // }
        return redirect()->route('vendor.products')->with('success_msg', 'Product has been created!');
    }
    public function productEdit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $prodcats = Prodcat::with('childrens')->where('parent_id', null)->get();
        $product_attributes = Attribute::where('product_id',$product->id)->get();
        if(!session()->has('target')){
			session()->flash('target','attribute');
		}
        $cities=City::all();
        return view('auth.seller.product.edit', compact('product', 'prodcats','product_attributes','cities'));
    }
    public function update(Product $product, Request $request)
    {

        $images = json_decode($product->images) ?? [];

        $newImage = $product->image;
        $request->validate(
            [
                "name"          => "required|max:200",
                "price"         => "required|regex:/^\\d*(\\.\\d{1,2})?$/",
                "sale_price"     => "nullable|regex:/^\\d*(\\.\\d{1,2})?$/",
                "quantity"      => "required|integer",
                "description"   => "required",
                "short_description"   => "required",
                // "image"         => "required|mimes:jpg,jpeg,png",
                "images.*"      => "mimes:jpg,jpeg,png",
                "dimensions"    => "nullable",
                "weight"        => "nullable",
                "vendor_price"  => "nullable",
                "post_code" => "required",
                "amenities" => "required",
                "expired_at"=>"required",
                "city_id"=>"required",

            ]
        );
        if($request->sale_price){
            if($request->price > $request->sale_price){
                $data['sale_price']=$request->sale_price;
            }else{
                return redirect()->back()->withErrors('sale-price greater than price');
            }
        }
        if ($request->file('image')) {

            $newImage = $request->image->store("products");
            Storage::delete($product->image);
        }
        if ($request->file('newimages')) {
            $images[] = $request->newimages->store("product-images");
        }

        if ($request->file('images')) {

            $oldimages = $images;

            foreach ($request->file('images') as $key => $img) {

                if (array_key_exists($key, $images)) {
                    Storage::delete($oldimages[$key]);
                    $images[$key] = $img->store("product-images");
                } else {

                    $images[] = $img->store("product-images");
                }
            }
            $images = json_encode($images);
        }
      
        $data = $product->update([
            'image' => $newImage,
            'images' => $images,
            'name' => $request->name,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'amenities' => $request->amenities,
            'expired_at' => $request->expired_at,
            'city_id' => $request->city_id,
            // 'weight' => $request->weight,
            // 'dimensions' => $request->dimensions,
            // 'is_offer' => $request->offer,


        ]);


        $slug = Str::slug($product->name);
        if (Product::where('slug', $slug)->first()) {
            $slug = $slug . '-' . $product->id;
        }
        $product->update([
            'slug' =>  $slug,
        ]);


        $product->prodcats()->sync($request->categories);
        return redirect()->route('vendor.products')->with('success_msg', 'Product has been Updated!');
    }
    public function productRemove(Product $product)
    {
        // dd($product);
        $product->delete();
        return back()->with('success_msg', 'Product has been deleted!');
    }

    protected function notification($user, $shop, $slug)
    {
        Notification::create([
            'url' => env('APP_URL') . '/product/' . $slug,
            'title' => 'New product Uploaded in ' . auth()->user()->shop->name,
            'shop_id' => $shop,
            'user_id' => $user,
        ]);
    }
}
