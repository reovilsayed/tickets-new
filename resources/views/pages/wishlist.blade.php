@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
<link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/shops.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<style>
     .ec-header-bottons .ec-header-btn .ec-header-count {
        top: -12px !important;
    }
</style>
@endsection
@section('content')
<x-app.header />
<!-- User history section -->
@if($products->count() == 0)
<div class="container">
    <div class="col-md-6 ms-5 mt-3">
        <a class="btn btn-inline btn-outline-dark border" href="{{ route('shops') }}">Continue Shopping</a>
    </div>
</div>
@endif
<div class="container">

    @if($products->count() > 0)

    <div class="row">
        <h5 class="m-4 poppins ">liked Products</h5>
        @foreach ($products as $product)
        <x-products.wishlist :product="$product" />
        @endforeach
    </div>

    @else
    <div class="row">
        <div class="col-md-12">
            <h3 class="m-4 poppins text-center " style="height: 60vh;"> No Products in Wishlist</h3>
        </div>
    </div>
    @endif
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