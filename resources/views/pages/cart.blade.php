@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/css/shops.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">
    <style>
         .navbar .navbar-nav .nav-link {
            color: black;
        }
    </style>
@endsection
@section('content')



    <section class="ec-page-content">
        <div class="container">
            <div class="row justify-content-between">
                <div class="ec-cart-leftside col-lg-7 col-md-12">
                
                    <div class="row justify-content-center mb-2">
                        @php
                            $items = Cart::getContent();
                        @endphp

                        @if (Cart::getTotalQuantity() > 0)
                            <div class="ec-cart-content">
                                <div class="ec-cart-inner">
                                    <h4 class="p-1 cart-heading text-cus-secondary h2">{{ Cart::getTotalQuantity() }} varer i din kurv</h4>
                                    @if (Cart::getTotalQuantity() > 0)
                                        <div class="row">


                                  
                                            
                                                 

                                                    @foreach ($items as $item)
                                                    
                                                        <div class="cart-item card rounded-4 mb-4">
                                                            <div class="card-body row box-shadow">
                                                               

                                                                <div class="col-md-3 center">
                                                                    <img class="cart-item-image"
                                                                        src="{{ Storage::url($item->model->image) }}"
                                                                        alt="">
                                                                </div>
                                                   
                                                                <div class="col-md-5  cart-item-text">
                                                                    <h1 class="font-size">{{ $item->name }}</h1>
                                                                  
                                                                    <a href="">

                                                                        @if ($item->model->quantity)
                                                                            <span class="text-success">In Stok</span>
                                                                        @else
                                                                            <span class="text-danger">Out of stock</span>
                                                                        @endif

                                                                    </a>
                                                               

                                                                    <form action="{{ route('cart.update') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <div class="form-group  col-md-12 d-flex">
                                                                            <input type="text" name="quantity"
                                                                            value="{{ $item->quantity }}"
                                                                            class="" id="">
                                               
                                                                                <input type="hidden" name="product_id"
                                                                                value="{{ $item->id }}" />
                                                                            <button type="submit" class="btn border btn-dark "
                                                                                style="margin-right: 0 !important" id="basic-addon2"><span>opdater</span></button>
                                            
                                                                        </div>
                                           
                                                                        <a href="{{ route('cart.destroy', $item->id) }}" onclick="return confirm('Are you sure you want to delete this item?');"><u>Fjern</u></a>
                                                                    </form>

                                                                </div>
                                                                <div
                                                                    class="col-md-3 justify-content-center align-item-center mt-3">
                                                                    <h1 class="cart-text">
                                                                        {{ Sohoj::price($item->price) }}</h1>
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach



                                        </div>
                                    @endif
                                </div>
                            </div>

                    </div>

                </div>
             
                <div class="ec-cart-rightside col-lg-4 col-md-12 " style="margin-top: 40px;">
                    <div class="ec-sidebar-wrap">
                
                        <div class="ec-sidebar-block mt-5 side-bar-box ">

                            <div class="ec-sb-block-content">
                                <div class="ec-cart-summary-bottom">
                                    <div class="ec-cart-summary p-4">

                                        <div>
                                            <span class="text-left">Total  ({{ Cart::getTotalQuantity() }} vare)</span>
                                            <span class="text-right">{{ Sohoj::price(Sohoj::newSubtotal()) }}</span>
                                        </div>
                                      
                                        @if (!session()->has('discount'))
                                            <div>
                                                <span class="text-left">Rabatkode</span>
                                                <span class="text-right"><a class="ec-cart-coupan">Apply Coupan</a></span>
                                            </div>

                                            <div class="ec-cart-coupan-content">
                                                <form class="ec-cart-coupan-form" name="ec-cart-coupan-form" method="POST"
                                                    action="{{ route('coupon') }}">
                                                    @csrf
                                                    <div class="form-group  col-md-12 d-flex">
                                                    <input class="" type="text" required=""
                                                        placeholder="Enter Your Coupan Code" name="coupon_code"
                                                        value="">
                                                        <button type="submit" class="btn border btn-dark "
                                                        style="margin-right: 0 !important" id="basic-addon2"><span>Apply</span></button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                        <div class="ec-cart-summary-total">
                                            <span class="text-left">Total beløb</span>
                                            <span class="text-right">{{ Sohoj::price(Sohoj::newSubtotal()) }}</span>
                                        </div>
                                        <a href="{{ route('checkout') }}" class="butn-dark2 mt-3"><span>Fortsæt til betaling</span></a>
                                    </div>


                                </div>

                            </div>

                        </div>
                     
                    </div>
                </div>
            </div>
        @else
            <div class=" col-md-12  m-5">
                <h3>No product has been added to cart. <a class="text-primary" href="{{ route('homepage') }}">Continue
                        Shopping</a></h3>
            </div>
            @endif

         


        </div>
    </section>

@endsection

@section('js')

<script src="{{asset('assets/frontend-assets/js/jquery-3.6.3.min.js')}}"></script>
<script>
      $(document).ready(function(){
    $(".ec-cart-coupan").click(function() {
        console.log('hello');
    $('.ec-cart-coupan-content').slideToggle('slow');
    });
    $(".ec-checkout-coupan").click(function() {
    $('.ec-checkout-coupan-content').slideToggle('slow');
    });
});
</script>
@endsection

