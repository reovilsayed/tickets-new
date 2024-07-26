<?php

namespace App\Models;

use App\City;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'expired_at' => 'datetime',
        'event_start_date' => 'datetime',
      ];
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function discount()
    {
        $discount_amount  = $this->price - $this->sale_price;
        $discount_percantage = ($discount_amount / $this->price) * 100;
        return round($discount_percantage);
    }
    public function prodcats()
    {
        return $this->belongsToMany(Prodcat::class)->withTimestamps();
    }
    public function facilities()
    {
        return $this->belongsToMany(Facility::class)->withTimestamps();
    }

    public function path()
    {
        return route('product_details', $this->slug);
    }
    public function attributes()
    {
      return $this->hasMany(Attribute::class);
    }
    public function subproducts(){
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }
    public function subproductsuser(){
        return $this->hasMany(Product::class, 'parent_id', 'id')->where('price','>', 0)->whereNotNull('variations');
    }
    public function scopeFilter($query)
    {
        //new
        return $query
            ->when(request()->filled('category'), function ($q) {
                return $q->whereHas('prodcats', function ($query) {
                    $query->where('slug', request()->category);
                });
            })
            ->when(request()->filled('city'), function ($q) {
                return $q->whereHas('city', function ($query) {
                    $query->where('slug', request()->city);
                });
            })
            ->when(request()->has('search'), function ($q) {
                return $q->where(function ($query) {
                    $query->where('name', 'LIKE', '%' . request()->search . '%')
                        ->orWhere('short_description', 'LIKE', '%' . request()->search . '%');
                });
            })
            ->when(request()->has('featured'), function ($q) {
                return $q->where('featured', 1);
            })
            ->when(request()->has('shop'), function ($q) {
                return $q->whereHas('shop', function ($query) {
                    $query->where('name', request()->shop);
                });
            })
            ->when(
                request()->has('ratings'),
                function ($q) {
                    return  $q->whereHas('ratings', function ($q) {
                        $q->where('rating',request()->ratings);
                    });
                }
            )

            ->when(request()->has('filter_products') && request()->filter_products == 'price-low-high', function ($q) {
                return $q->orderBy('price', 'asc');
            })
            ->when(request()->has('filter_products') && request()->filter_products == 'price-high-low', function ($q) {
                return $q->orderBy('price', 'desc');
            })
            ->when(request()->has('filter_products') && request()->filter_products == 'most-popular', function ($q) {
                return $q->orderBy('total_sale', 'desc');
            })
            ->when(request()->has('filter_products') && request()->filter_products == 'trending', function ($q) {
                return $q->orderBy('views', 'desc');
            })
            ->when(request()->has('filter') && request()->filter == 'expired_date', function ($q) {
                return $q->where('expired_at','<', Carbon::today());
            })
            ->when(request()->has('filter') && request()->filter == 'running', function ($q) {
                return $q->where('expired_at','>=', Carbon::today());
            })
            ;
            // ->when(Session::has('location'), function ($q) {
            //     $postcode = Session::get('location.postcode');
            //     $q->whereIn('post_code', $postcode);
            // }); // default order
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class)->where('status', 1)->latest();
    }

    public function setVariationsAttribute($value)
    {
      $this->attributes['variations'] = json_encode($value);
    }
    public function getVariationsAttribute($value)
    {
 
      if ($value) {
        return json_decode($value);
      }
    }
  
}

