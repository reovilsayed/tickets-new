@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
<link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/shops.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/store_front.css') }}">
<style>
    .rating-stars {
        width: 145px !important;
    }

    .footer-font {
        font-size: 25px !important;
    }
</style>
@endsection
@section('content')
<x-app.header />
<section class="w-100 " style="background-color: #EDEDED;border:1px 0 solid #EDEDED">
    <div class="top-bn container p-0 flex-wrap ">

        <div class="row align-items-center">
            <div class="col-md-3 d-flex justify-content-center">
                <a href=""><img style="width: 120px; height: 100px; object-fit: cover; margin-left: 10px" src="{{ Storage::url($shop->logo) }}" alt=""></a>
            </div>

            <div class="col-md-6">
                <div>
                    <h2 class="text-center"><span style="
                    font-size: 25px;
                ">{{ $shop->name }}</span></h2>
                    <p class="text-center" style="color: #787885">{{ $shop->short_description }}
                    </p>
                    <p class="text-center" style="font-size: 15px;
                font-weight: 400;color: #373737;">
                        {{ $shop->city }}, {{ $shop->state }}
                    </p>
                </div>
                <div class="d-flex justify-content-center flex-wrap">
                    <p class="text-center " style="font-size: 15px;
                    font-weight: 400;"> <span class="" style="background-color:#373737; border-radius:50%; padding:0 3px"><i class="far fa-star text-white"></i></span> Silver Seller | {{ $shop->orders->count() }}
                        items sold |

                    </p>
                    <div class="ec-single-rating-wrap d-inline">
                        <div class="ec-single-rating">
                            <input value="{{ Sohoj::average_rating($shop->ratings) }}" class="rating published_rating" data-size="sm">
                        </div>

                    </div>
                    <span class="mt-2 ms-2">
                        ({{ $shop->ratings->count() }})
                    </span>
                </div>
            </div>
            <div class="col-md-3 d-flex justify-content-center">
                <div>
                    @auth
                    <form action="{{ route('follow', $shop) }}" method="post" style="display:inline">
                        @csrf
                        @php
                        $follow = auth()
                        ->user()
                        ->follows($shop);
                        @endphp
                        <button class="btn btn-dark rounded-3 btn-hover button-bn" style="height: 36px; line-height: 36px">{{ $follow ? 'Unfollow' : 'Follow' }}</button>
                    </form>
                    @else
                    <a class="btn btn-dark" href="{{route('login')}}">Follow</a>
                    @endauth

                    <a href="{{route('massage.create',$shop->id)}}"><i class="fa-regular fa-envelope fa-2xl" style="width: 40px; height: 40px;margin-left: 38px"></i></a>
                </div>
            </div>
        </div>


    </div>
</section>

<section class="w-100 ">
    <div class="">

        <a href=""> <img class="banner" src=" {{ $shop->banner ? Storage::url($shop->banner) : asset('assets/img/store_front/banner.png') }}" alt=""></a>
    </div>

</section>

<section>
    <nav class="navbar navbar-expand-lg bg-light mt-0" style="height: 50px;z-index:99">
        <div class="w-100">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" style="background-color:#EAFAE1;" id="navbarSupportedContent">
                <div class="container">
                    <div class="col-md-12 align-self-center">
                        <div class="ec-main-menu d-flex ">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li>
                                    <a href="#">Home</a>
                                </li>
                                <li>
                                    <a href="{{ route('store_front', [$shop->slug, 'shop_products' => 'most-popular']) }}">Popular
                                        Items</a>

                                </li>
                                <li>
                                    <a href="#offer">Promotions </a>
                                </li>
                                @if ($shop->menuTitle1)
                                <li>
                                    <a href="{{ $shop->menuLink1 }}">{{ $shop->menuTitle1 }} </a>
                                </li>
                                @endif
                                @if ($shop->menuTitle2)
                                <li>
                                    <a href="{{ $shop->menuLink2 }}">{{ $shop->menuTitle2 }} </a>
                                </li>
                                @endif

                                <div class="wrap mt-3 ms-md-5">
                                    <form action="{{ route('store_front', $shop->slug) }}" method="get">
                                        <div class="search">
                                            <input type="text" name="search" class="searchTerm" placeholder="Search for product?">
                                            <button type="submit" class="searchButton">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</section>

<section class="container mt-4">
    <div class="shop-pro-inner">
        <div class="row">
            @if (count($shop->products) == !0)
            @foreach ($shop->products as $product)
            <x-products.product-2 :product="$product" />
            @endforeach
            @endif
        </div>
    </div>
</section>
<section class="container mt-2" id="offer">

    <x-offer :shop="$shop" />

</section>

<!-- <section class="container mt-4">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="shop-pro-inner">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <x-products.product-2 :product ="$products" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </section> -->

<section class="seller-footer">
    <div class="col-md-12 seller-icon p-4">

        <ul class="mb-2" style="width: 280px">
            <li class="list-inline-item"><a target="_blank" class="hdr-facebook" href="{{ $shop->facebook }}"><i class="ecicon eci-facebook e rounded-circle p-3  d-flex justify-content-center" style="font-size:15px; height:47px; width:45px;"></i></a>
            </li>
            <li class="list-inline-item"><a target="_blank" class="hdr-linkedin" href="{{ $shop->linkedin }}"><i class="ecicon eci-linkedin  rounded-circle p-3 " style="font-size:15px"></i></a>
            </li>
            <li class="list-inline-item"><a target="_blank" class="hdr-instagram" href="{{ $shop->instagram }}"><i class="ecicon eci-instagram rounded-circle p-3  border" style="font-size:15px; "></i></a>
            </li>
            <li class="list-inline-item"><a target="_blank" class="hdr-twitter" href="{{ $shop->twitter }}"><i class="ecicon eci-twitter  rounded-circle p-3  border" style="font-size:15px"></i></a>
            </li>

        </ul>

        <div class="seller-footer mt-4 text-center">
            <h2><strong>About</strong> {{ $shop->name }}</h2>
            <p>{{ $shop->description }}</p>
            {{-- <span><a href="">Read more</a></span> --}}
            <div style="border-top: 1px solid #eeeeee;border-bottom: 1px solid #eeeeee; "></div>
        </div>
        <div class="container flex-wrap">
            <h5 class="my-5" style="margin-left:30px;">Reviews</h5>
            @if ($shop->ratings()->count())
            @foreach ($shop->ratings as $rating)
            <div class="row mb-5">
                <div class="ec-t-review-item d-flex align-items-center">
                    <div class="ec-t-review-avtar">
                        <img style="height: 60px; width:60px;" src="{{ asset('assets/img/single_product/person.png') }}" alt="" />
                    </div>
                    <div class="ec-t-review-content">
                        <div class="ec-t-review-top">
                            <div class="ec-t-review-name">{{ $rating->name }}</div>
                            <div class="ec-t-review-rating">
                                <input name="rating" type="number" value="{{ $rating->rating }}" class="rating published_rating" data-size="sm">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="ec-t-review-bottom">
                    <p style="margin-left:15px; width:350px;">
                        {{ $rating->review }}
                    </p>
                </div>
            </div>
            @endforeach
            @else
            <p class="d-flex justify-content-center" style="color: red">No reviews</p>
            @endif

            <div class="d-flex justify-content-center align-items-end mb-2">
                {{-- <a href="">See
                        more reviews</a> --}}

            </div>
            <div style="border-top: 1px solid #eeeeee;border-bottom: 1px solid #eeeeee; "></div>
        </div>
        <div class="container mt-5 d-flex justify-content-around flex-wrap" style="margin-left:7px;">
            <p class="footer-font">Owner : <strong>{{ $shop->user->name }}</strong></p>
            <p class="footer-font">Company Name : <strong>{{ $shop->company_name }} </strong></p>
            <p class="footer-font">Joined :
                <strong>{{ $shop->created_at ? $shop->created_at->format('Y') : '' }}</strong>
            </p>
            <p class="footer-font">Sales : <strong>{{ $shop->orders->count() }} </strong></p>



        </div>
        <div class="container mb-3" style="border: 1px solid #eeeeee"></div>
        @if ($shop->shopPolicy)
        <div class="container d-flex mt-4 mb-4 flex-wrap" style="gap: 200px; margin-left:100px;">
            <h5>Shop policy</h5>
            <div>

                <li><i class="fa-solid fa-circle p-2"></i>{{ $shop->shopPolicy ? $shop->shopPolicy->cancellation : '' }}
                </li>

                <li><i class="fa-solid fa-circle p-2"></i>
                    {{ $shop->shopPolicy ? $shop->shopPolicy->return_exchange : '' }}
                </li>
                <li><i class="fa-solid fa-circle p-2"></i>
                    {{ $shop->shopPolicy ? $shop->shopPolicy->payment_option : '' }}
                </li>
                <li><i class="fa-solid fa-circle p-2"></i>
                    {{ $shop->shopPolicy ? $shop->shopPolicy->delivery : '' }}
                </li>

            </div>
        </div>
        @else
        <span class="text-danger">No Shop Policy Added</span>
        @endif
    </div>


    </div>

</section>

<!-- Modal -->
<div class="modal fade" id="massageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Send Massage</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('massage.store', $shop) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" required name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="massage">Massage</label>
                        <textarea class="form-control" rows="5" name="massage" id="massage"></textarea>
                    </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

<script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
@endsection