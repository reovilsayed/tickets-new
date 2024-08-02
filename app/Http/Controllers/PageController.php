<?php

namespace App\Http\Controllers;

use App\City;
use App\Models\Address;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Email;
use App\Models\Event;
use App\Models\Facility;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Prodcat;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Shop;
use App\Models\User;
use App\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\Session;
use TCG\Voyager\Models\Page;

class PageController extends Controller
{
    public function home()
    {
        $events = Event::where('status', 1)->get();
        return view('pages.home', compact('events'));
    }
    public function event_details(Event $event)
    {
        $event->load('products');

        $products = [];
        $products['all'] = $event->products;
        foreach ($event->dates() as $date) {
            $products[$date] = $event->products->filter(fn ($product) => in_array($date, $product->dates));
        }
        return view('pages.event_details', compact('event', 'products'));
    }
  
    public function shops()
    {
        $products = Product::where("status", 1)->limit(12)->filter()->paginate(10);
        $categories = Prodcat::has('products')->latest()->get();
        $cities = City::all();

        return view('pages.shops', compact('products', 'categories', 'cities'));
    }
    public function about()
    {
        $ratings = Rating::latest()->get();
        $facilities = Facility::latest()->get();
        return view('pages.about', compact('ratings', 'facilities'));
    }
    public function contact()
    {
        return view('pages.contact');
    }
    public function product_details($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $related_products = Product::whereNull('parent_id')->limit(16)->get();
        $amenities = explode(',', $product->amenities);
        // $product->increment('views');


        // $recommand = session()->get('recommand', []);

        // if (!in_array($product->id, $recommand)) {
        //     $recommand[] = $product->id;
        //     session()->put('recommand', $recommand);
        // }
        return view('pages.product_details', compact('related_products', 'product', 'amenities'));
    }
    public function cart()
    {
        $latest_shops = Shop::where("status", 1)
            ->whereHas('products', function ($query) {
                $query->whereNull('parent_id');
            })->latest()->limit(8)->get();
        return view('pages.cart', compact('latest_shops'));
    }


    public function dashboard()
    {

        return view('auth.user.dashboard');
    }
    public function addressEdit(Address $address)
    {
        return view('auth.user.information', ['address' => $address]);
    }
    public function addressDestroy(Address $address)
    {

        $address->delete($address);

        return back()->with('success_msg', 'Address has been removed!');
    }



    public function order_index()
    {
        $latest_orders = Order::where('user_id', auth()->user()->id)->where('status', 0)->orWhere('status', 3)->latest()->get();
        $past_orders = Order::where('user_id', auth()->user()->id)->where('status', 1)->latest()->get();

        return view('auth.user.order.index', compact('latest_orders', 'past_orders'));
    }


    public function checkout(Event $event)
    {

        return view('pages.checkout', compact('event'));
    }
    public function store_front($slug)
    {
        $shop = Shop::where('slug', $slug)->products()->firstOrFail();



        return view('pages.store_front', compact('shop'));
    }


    // public function order_page()
    // {
    //     return view('pages.order_page');
    // }
    public function thankyou(Order $order)
    {
        // $latest_products = Product::where("status", 1)->latest()->limit(24)->whereNull('parent_id')->get();
        return view('pages.thankyou', compact('order'));
    }
    public function rating(Request $request)
    {
        $product = Product::find($request->product_id);
        Rating::create([
            "name" => $request->name,
            "email" => $request->email,
            "rating" => $request->rating,
            "review" => $request->comment,
            "product_id" => $product->id,
            'user_id' => Auth()->id(),
            'shop_id' => $product->shop->id,
        ]);
        return back()->with('success_msg', 'Thanks for your review');
    }
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'unique:emails,email'],
        ], [
            'email.unique' => 'You already subscribed'
        ]);
        Email::create([
            "email" => $request->email,
        ]);
        return back()->with('success_msg', 'Thanks for your subscription');
    }
    public function quickview()
    {
        $product = Product::where('id', request()->product_id)->first();
        return view('layouts.quick_view', compact('product'));
    }

    public function vendors(Request $request)
    {
        if (auth()->check() && $request->type == 'liked') {
            $shops = auth()->user()->followedShops()->active();
        } else {
            $shops = Shop::active();
        }
        $shops = $shops->with([
            'products' => function ($query) {
                $query->whereHas('prodcats', function ($query) {
                    $query->where('slug', request()->category);
                });
            }
        ])
            ->when($request->filled('category'), function ($query) {
                $query->whereHas('products', function ($query) {
                    $query->whereHas('prodcats', function ($query) {
                        $query->where('slug', request()->category);
                    });
                });
            })
            ->get();
        return view('pages.vendors', compact('shops'));
    }

    public function follow(Shop $shop)
    {
        $user = auth()->user();

        $user->followedShops()->toggle($shop->id);

        if ($user->follows($shop)) {
            return redirect()->back()->with('success_msg', 'You are now following ' . $shop->name);
        } else {
            return redirect()->back()->with('success_msg', 'You have unfollowed ' . $shop->name);
        }
    }
    public function getPage($slug = null)
    {
        $page = Page::where('slug', $slug)->where('status', 'active');
        $page = $page->firstOrFail();
        return view('pages.page')->with('page', $page);
    }
    public function followShops()
    {
        return view('pages.likedShop');
    }
    public function setLocation(Request $request)
    {
        $postcodes = $request->input('postcodes');
        $lng = $request->input('lng');
        $lat = $request->input('lat');
        $radius = $request->input('radius');
        $state = $request->input('state');
        $uniquePostcodes = array_unique($postcodes);

        // Process the data as needed

        // Return the response
        $response = [
            'postcode' => $uniquePostcodes,
            'lng' => $lng,
            'lat' => $lat,
            'radius' => $radius,
            'state' => $state,
        ];
        Session::put('location', $response);

        return response()->json($response);
    }
    public function locationReset()
    {
        Session::forget('location');
        return back()->with('success_msg', 'Location reset');
    }

    public function contactStore(Request $request)
    {
        // dd($request->all());
        $contact = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        Contact::create($contact);
        return back()->with('success_msg', 'Contact submit successfully');
    }
    public function posts()
    {
        $posts = Post::published()->filter()->latest()->paginate(10)->onEachSide(2)->withQueryString();
        return view('pages.posts', compact('posts'));
    }
    public function post($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $recentPosts = Post::where('id', '!=', $post->id)->published()->latest()->limit(5)->get();
        $categories = Category::all();
        return view('pages.post_details', compact('post', 'recentPosts', 'categories'));
    }

}
