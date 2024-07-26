<?php

namespace App\Models;

use App\Models\Traits\HasMeta;
use Darryldecode\Cart\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use TCG\Voyager\Facades\Voyager;

class Shop extends Model
{
    use HasFactory, HasMeta;
    protected $guarded = [];

    protected $meta_attributes = [
        "image1",
        "title1",
        "category1",
        "link1",
        "image2",
        "title2",
        "category2",
        "link2",
        "facebook",
        "linkedin",
        "instagram",
        "twitter",
        "menuTitle1",
        "menuLink1",
        "menuTitle2",
        "menuLink2",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function massages()
    {
        return $this->hasMany(Massage::class, 'reciver_id');
    }
    public function shopPolicy()
    {
        return $this->hasOne(ShopPolicy::class);
    }


    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeProducts($query)
    {

        return $query->when(Session::has('location'), function ($q) {
            $postcode = Session::get('location.postcode');
            $q->whereIn('post_code', $postcode);
        })
        // ->when(auth()->check(), function ($q) {
        //     $q->where('post_code', Auth()->user()->shopAddress->post_code);
        // })
        ->with(['products' => function ($query) {
            $query->when(request()->filled('category'), function ($q) {
                $q->whereHas('prodcats', function ($query) {
                    $query->where('slug', request()->category);
                });
            })->when(request()->has('search'), function ($q) {
                return $q->where(function ($query) {
                    $query->where('name', 'LIKE', '%' . request()->search . '%')
                        ->orWhere('short_description', 'LIKE', '%' . request()->search . '%');
                });
            })
                ->when(request()->has('search'), function ($q) {
                    $q->orWhereHas('shop', function ($query) {
                        $query->where('name', request()->search);
                    });
                })
                ->when(request()->has('shop_products') && request()->shop_products == 'price-low-hight', function ($q) {
                    $q->orderBy('price', 'asc');
                })
                ->when(request()->has('shop_products') && request()->shop_products == 'price-high-low', function ($q) {
                    $q->orderBy('price', 'desc');
                })
                ->when(request()->has('shop_products') && request()->shop_products == 'most-popular', function ($q) {
                    $q->orderBy('total_sale', 'desc');
                });
        }])
            ->has('products');
    }
    public function scopeShop($query)
    {
        return $query
            ->when(request()->has('search'), function ($q) {
                return $q->where(function ($query) {
                    $query->where('name', 'LIKE', '%' . request()->search . '%');
                });
            })
            ->when(request()->has('shop_products') && request()->shop_products == 'price-low-hight', function ($q) {
                $q->orderBy('sale_price', 'asc');
            })
            ->when(request()->has('shop_products') && request()->shop_products == 'price-high-low', function ($q) {
                $q->orderBy('sale_price', 'desc');
            })
            ->when(request()->has('shop_products') && request()->shop_products == 'most-popular', function ($q) {
                $q->orderBy('total_sale', 'desc');
            })->when(Session::has('location'), function ($q) {
                $postcode = Session::get('location.postcode');
                $q->whereIn('post_code', $postcode);
            })

            ->orderBy('created_at', 'desc');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'shop_user', 'shop_id', 'user_id')->withTimestamps();
    }
    public function monthlyCharge()
    {
        $chargeable_product_count = $this->products()->count() - 10;
        $per_product_charge = 75;

        return (max($chargeable_product_count, 0) * $per_product_charge);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class)->where('status', 1)->latest();
    }
    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }
    public function notifications()
    {
        return $this->hasmany(Notification::class, 'shop_id');
    }
}
