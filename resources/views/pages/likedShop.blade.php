@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
<link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/shops.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<style>
 
</style>
@endsection
@section('content')
<x-app.header />

@auth
@if(auth()->user()->followedShops->count() > 0)
<div class="container">
    <div class="row">
        <h5 class="m-4 poppins ">Followed Shop</h5>
        @foreach (auth()->user()->followedShops as $shop)
        <div class="col-md-2 mb-6  pro-gl-content-shop shadow-sm shop-cards mx-3 mb-4">
            <div class="ec-product-inner position-relative ">

       
                <div class="ec-pro-image-outer ">
                    <div class="ec-pro-image " style="border:none">
                        <a href="{{ route('store_front', $shop->slug) }}" class="image">
                            <img class="main-image" src="{{ Storage::url($shop->logo) }}" style="object-fit: cover;" alt="Product" />
                            <img class="hover-image" src="{{ Storage::url($shop->logo) }}" style="object-fit: cover;" alt="Product" />
                        </a>


                    </div>
                </div>
                <div class="ec-pro-content text-center" style=" background-color: inherit">
                    <h5 class="ec-pro-title ec-pro-title-shop"><a style="font-size: 14px" href="{{ route('store_front', $shop->slug) }}">{{ $shop->name }}</a></h5>
                    <div class="ec-pro-list-desc">
                        <p style="font-size: 12px">{{ Str::limit($shop->short_description, $limit = 30, $end = '...') }}</p>
                    </div>
                    <div class="d-flex flex-wrap justify-content-center btn-group-sm" style="margin-right: 5px" role="group" aria-label="Basic example">
                        @if ($shop->tags == !null)
                        @php
                        $tags = explode(',', $shop->tags);
                        @endphp
                        @foreach ($tags as $tag)
                        <span class="btn-light py-1 px-2 me-2" style="font-size: 10px;color: #787885;height: 25px;">{{ Str::limit($tag, $limit = 7, $end = '...') }}</span>
                        @endforeach
                        @endif



                    </div>

                    <div class="ec-pro-rating d-flex justify-content-center align-items-center" style="margin-top:13px">
                        <input value="{{ Sohoj::average_rating($shop->ratings) }}" class="rating published_rating" data-size="sm">
                        <span class="ms-2">({{ $shop->ratings->count() }})</span>
                    </div>



                </div>
            </div>
        </div>
        @endforeach
    </div>


    @else
    <h3 class="m-4 poppins text-center "> No Shop in liked</h3>
    @endif
    @else
    <h2 class="text-danger text-center m-4" style="height: 60vh;">Please login</h2>
    @endauth
</div>
</div>

<!-- End User history section -->
@endsection
@section('js')
<script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}">
</script>
<script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}">
</script>

<script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
@endsection