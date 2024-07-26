@php
    $route = route('shops');
@endphp

@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('shops.css') }}" />


    <style>
        .ec-product-inner .ec-pro-image .ec-pro-actions .wishlist {
            position: absolute !important;
            right: 10px !important;
            bottom: 62px !important;
            border: 1px solid #eeeeee;
        }

        .navbar .navbar-nav .nav-link {
            color: black;
        }

        .navbar .navbar-toggler-icon, .navbar .icon-bar{
            color: #000;
        }
        @media screen and (max-width:480px) {
            .shopsside-bar{
                margin-top: 80px;
            }
        }
        .active{
            color: #9F8061;
        }
    </style>
@endsection
@section('content')
    <!-- Ec Shop page -->
    <div class="shopsside-bar container-fluid p-0">
        <div class="row ">
            <aside class="col-md-2">
                <div class="wrapper">
                    <a href="{{ route('shops') }}" class="w-100 butn-dark2" style="padding: 13px 6px"><span>{{__('words.remove_btn')}}</span></a>

                    <!-- <div class="filters"> <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#mobile-filter" aria-expanded="true" aria-controls="mobile-filter">Filter<span class="px-1 fas fa-filter"></span></button> </div> -->
                    <div id="mobile-filter">
                        <div class="py-3">
                            <h5 class="font-weight-bold text-cus-secondary">Categories</h5>
                            <ul class="list-group">
                                @foreach ($categories as $category)
                                    <li
                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                        <a href="javascript::void(0)"
                                            onclick='updateSearchParams("category","{{ $category->slug }}","{{ $route }}")'>{{ $category->name }}</a>
                                        <span
                                            class="badge badge-primary badge-pill">{{ $category->products->count() }}</span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        {{-- <div class="py-3">
                        <h5 class="font-weight-bold text-cus-secondary">Brands</h5>
                        <form class="brand">
                            <div class="form-inline d-flex align-items-center py-1"> <label class="tick">Royal Fields <input type="checkbox"> <span class="check"></span> </label> </div>
                            <div class="form-inline d-flex align-items-center py-1"> <label class="tick">Crasmas Fields <input type="checkbox" checked> <span class="check"></span> </label> </div>
                            <div class="form-inline d-flex align-items-center py-1"> <label class="tick">Vegetarisma Farm <input type="checkbox" checked> <span class="check"></span> </label> </div>
                            <div class="form-inline d-flex align-items-center py-1"> <label class="tick">Farmar Field Eve <input type="checkbox"> <span class="check"></span> </label> </div>
                            <div class="form-inline d-flex align-items-center py-1"> <label class="tick">True Farmar Steve <input type="checkbox"> <span class="check"></span> </label> </div>
                        </form>
                    </div> --}}
                        {{-- <div class="py-3">
                            <h5 class="font-weight-bold text-cus-secondary">Rating</h5>
                            <form class="rating" id="ratingForm">
                                <div class="form-inline d-flex align-items-center py-2"> <label class="tick"><span
                                            class="fas fa-star"></span> <span class="fas fa-star"></span> <span
                                            class="fas fa-star"></span> <span class="fas fa-star"></span> <span
                                            class="fas fa-star"></span> <input type="checkbox" value="5"
                                            {{ request('ratings') == 5 ? 'checked' : '' }}> <span class="check"></span>
                                    </label> </div>
                                <div class="form-inline d-flex align-items-center py-2"> <label class="tick"> <span
                                            class="fas fa-star"></span> <span class="fas fa-star"></span> <span
                                            class="fas fa-star"></span> <span class="fas fa-star"></span> <span
                                            class="far fa-star px-1 text-muted"></span> <input type="checkbox"
                                            value="4" {{ request('ratings') == 4 ? 'checked' : '' }}> <span
                                            class="check"></span> </label> </div>
                                <div class="form-inline d-flex align-items-center py-2"> <label class="tick"><span
                                            class="fas fa-star"></span> <span class="fas fa-star"></span> <span
                                            class="fas fa-star"></span> <span class="far fa-star px-1 text-muted"></span>
                                        <span class="far fa-star px-1 text-muted"></span> <input type="checkbox"
                                            value="3" {{ request('ratings') == 3 ? 'checked' : '' }}> <span
                                            class="check"></span> </label> </div>
                                <div class="form-inline d-flex align-items-center py-2"> <label class="tick"><span
                                            class="fas fa-star"></span> <span class="fas fa-star"></span> <span
                                            class="far fa-star px-1 text-muted"></span> <span
                                            class="far fa-star px-1 text-muted"></span> <span
                                            class="far fa-star px-1 text-muted"></span> <input type="checkbox"
                                            value="2" {{ request('ratings') == 2 ? 'checked' : '' }}> <span
                                            class="check"></span> </label> </div>
                                <div class="form-inline d-flex align-items-center py-2"> <label class="tick"> <span
                                            class="fas fa-star"></span> <span class="far fa-star px-1 text-muted"></span>
                                        <span class="far fa-star px-1 text-muted"></span> <span
                                            class="far fa-star px-1 text-muted"></span> <span
                                            class="far fa-star px-1 text-muted"></span> <input type="checkbox"
                                            value="1" {{ request('ratings') == 1 ? 'checked' : '' }}> <span
                                            class="check"></span> </label> </div>
                            </form>
                        </div> --}}
                    </div>
                    <div class="content py-md-0 py-3">
                        <section id="sidebar">
                            <div class="py-3">
                                <h5 class="font-weight-bold text-cus-secondary">{{__('words.categories')}}</h5>
                                <ul class="list-group">
                                    @foreach ($categories as $category)
                                        <li
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category">
                                            <a href="javascript::void(0)"
                                                onclick='updateSearchParams("category","{{ $category->slug }}","{{ $route }}")'>{{ $category->name }}</a>
                                            <span
                                                class="badge badge-primary badge-pill">{{ $category->products->count() }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="py-3">
                                <h5 class="font-weight-bold text-cus-secondary">{{__('words.cities')}}</h5>
                                <form class="brand" id="citiesForm">
                                    @foreach ($cities as $city)
                                        <div class="form-inline d-flex align-items-center py-1"> <label
                                                class="tick">{{ $city->name }} <input type="checkbox"
                                                    value="{{ $city->slug }}"
                                                    {{ request('city') == $city->slug ? 'checked' : '' }}>
                                                <span class="check"></span> </label> </div>
                                    @endforeach
                                </form>
                            </div>
                            {{-- <div class="py-3">
                            <h5 class="font-weight-bold text-cus-secondary">Rating</h5>
                            <form class="rating" id="ratingForm">
                                <div class="form-inline d-flex align-items-center py-2"> <label class="tick"><span class="fas fa-star"></span> <span class="fas fa-star"></span> <span class="fas fa-star"></span> <span class="fas fa-star"></span> <span class="fas fa-star"></span> <input type="checkbox" value="5" {{request('ratings')==5 ? 'checked' :'' }}> <span class="check"></span> </label> </div>
                                <div class="form-inline d-flex align-items-center py-2"> <label class="tick"> <span class="fas fa-star"></span> <span class="fas fa-star"></span> <span class="fas fa-star"></span> <span class="fas fa-star"></span> <span class="far fa-star px-1 text-muted"></span> <input type="checkbox" value="4" {{request('ratings')==4 ? 'checked' :'' }}> <span class="check"></span> </label> </div>
                                <div class="form-inline d-flex align-items-center py-2"> <label class="tick"><span class="fas fa-star"></span> <span class="fas fa-star"></span> <span class="fas fa-star"></span> <span class="far fa-star px-1 text-muted"></span> <span class="far fa-star px-1 text-muted"></span> <input type="checkbox" value="3" {{request('ratings')==3 ? 'checked' :'' }}> <span class="check"></span> </label> </div>
                                <div class="form-inline d-flex align-items-center py-2"> <label class="tick"><span class="fas fa-star"></span> <span class="fas fa-star"></span> <span class="far fa-star px-1 text-muted"></span> <span class="far fa-star px-1 text-muted"></span> <span class="far fa-star px-1 text-muted"></span> <input type="checkbox" value="2" {{request('ratings')==2 ? 'checked' :'' }}> <span class="check"></span> </label> </div>
                                <div class="form-inline d-flex align-items-center py-2"> <label class="tick"> <span class="fas fa-star"></span> <span class="far fa-star px-1 text-muted"></span> <span class="far fa-star px-1 text-muted"></span> <span class="far fa-star px-1 text-muted"></span> <span class="far fa-star px-1 text-muted"></span> <input type="checkbox" value="1" {{request('ratings')==1 ? 'checked' :'' }}> <span class="check"></span> </label> </div>
                            </form>
                        </div> --}}
                        </section> <!-- Products Section -->

                    </div>
                </div>

            </aside>
            <div class="col-md-10">

                <section class="ec-page-content section-space-p">
                    <div class="container">
                        <div class="row">
                            <div class="ec-shop-rightside col-lg-12 col-md-12">
                                <!-- Shop Top Start -->
                                <div class="ec-pro-list-top d-flex ">
                                    <div class="col-md-6 ec-grid-list">
                                        {{-- <div class="ec-gl-btn">
                                            <p>Results For “ <span style="color:#3BB77E ">{{ request()->search }}</span> ”
                                            </p>
                                        </div> --}}
                                    </div>
                                    <div class="col-md-6 ec-sort-select">
                                        <span class="sort-by text-end">Sorter</span>
                                        <div class="ec-select-inner" style="height:70px;border:none;">
                                            <select name="ec-select"
                                                onchange='updateSearchParams("filter",this.value,"{{ $route }}")'
                                                id="ec-select" style="font-weight: 600;">

                                                <option value="">{{__('words.select')}}
                                                </option>
                                                <option value="expired_date"
                                                    {{ request()->filter == 'expired_date' ? 'selected' : '' }}>{{__('words.expired_date')}}</option>
                                                <option value="running"
                                                    {{ request()->filter == 'running' ? 'selected' : '' }}>{{__('words.running')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Shop Top End -->

                                <!-- Shop content Start -->
                                <div class="">
                                    <section class="rooms1">
                                        <div class="container">
                                            <div class="row">
                                            </div>
                                            <div class="row">
                                                @foreach ($products as $product)
                                                    <div class="col-sm-6 col-md-6 col-xs-2 col-xl-4">
                                                        <x-products.product :product=$product />
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </section>
                                    {{$products->links()}}
                                    <!-- Ec Pagination Start -->
                                    {{-- <div class="col d-flex justify-content-center">
                                        <div class="pagination d-flex justify-content-center  align-items-center">
                                            <button class="btn btn-dark-light rounded"><i
                                                    class="fi-rr-arrow-alt-left"></i></button>
                                            <p>Se mere</p>
                                            <button class="btn btn-dark rounded"><i
                                                    class="fi-rr-arrow-alt-right"></i></button>
                                        </div>
                                    </div> --}}

                                </div>

                            </div>
                            <!-- Sidebar Area Start -->
                            {{-- <div class="filter-sidebar-overlay"></div>
                <div class="ec-shop-leftside filter-sidebar">
                    <div class="ec-sidebar-heading">
                        <h1>Filter Products By</h1>
                        <a class="filter-cls-btn" href="javascript:void(0)">×</a>
                    </div>
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Category Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Category</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" checked /> <a href="#">clothes</a><span class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" /> <a href="#">Bags</a><span class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" /> <a href="#">Shoes</a><span class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" /> <a href="#">cosmetics</a><span class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" /> <a href="#">electrics</a><span class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" /> <a href="#">phone</a><span class="checked"></span>
                                        </div>
                                    </li>
                                    <li id="ec-more-toggle-content" style="padding: 0; display: none;">
                                        <ul>
                                            <li>
                                                <div class="ec-sidebar-block-item">
                                                    <input type="checkbox" /> <a href="#">Watch</a><span class="checked"></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="ec-sidebar-block-item">
                                                    <input type="checkbox" /> <a href="#">Cap</a><span class="checked"></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item ec-more-toggle">
                                            <span class="checked"></span><span id="ec-more-toggle">More
                                                Categories</span>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Size Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Size</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" value="" checked /><a href="#">S</a><span class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" value="" /><a href="#">M</a><span class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" value="" /> <a href="#">L</a><span class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" value="" /><a href="#">XL</a><span class="checked"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item">
                                            <input type="checkbox" value="" /><a href="#">XXL</a><span class="checked"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Color item -->
                        <div class="ec-sidebar-block ec-sidebar-block-clr">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Color</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <ul>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span style="background-color:#c4d6f9;"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span style="background-color:#ff748b;"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span style="background-color:#000000;"></span>
                                        </div>
                                    </li>
                                    <li class="active">
                                        <div class="ec-sidebar-block-item"><span style="background-color:#2bff4a;"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span style="background-color:#ff7c5e;"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span style="background-color:#f155ff;"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span style="background-color:#ffef00;"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span style="background-color:#c89fff;"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span style="background-color:#7bfffa;"></span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ec-sidebar-block-item"><span style="background-color:#56ffc1;"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sidebar Price Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Price</h3>
                            </div>
                            <div class="ec-sb-block-content es-price-slider">
                                <div class="ec-price-filter">
                                    <div id="ec-sliderPrice" class="filter__slider-price" data-min="0" data-max="250" data-step="10"></div>
                                    <div class="ec-price-input">
                                        <label class="filter__label"><input type="text" class="filter__input"></label>
                                        <span class="ec-price-divider"></span>
                                        <label class="filter__label"><input type="text" class="filter__input"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <!-- End Shop page -->
@endsection
@section('js')
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>




    <script>
        var shopUrl = "{{ route('shops') }}";

        $(document).ready(function() {
            $('#citiesForm input[type="checkbox"]').on('change', function() {
                if ($(this).is(':checked')) {
                    updateSearchParams("city", $(this).val(), shopUrl);
                } else {
                    removeSearchParam("city", shopUrl);
                }
            });

            $("#price-slider").slider({
                range: true,
                min: {{ request()->has('priceMin') ? request('priceMin') : 0 }},
                max: {{ request()->has('priceMax') ? request('priceMax') : 1000 }},
                values: [0, 1000],
                slide: function(event, ui) {
                    $("#minPriceDisplay").text(ui.values[0]);
                    $("#maxPriceDisplay").text(ui.values[1]);
                },
                stop: function(event, ui) {
                    updateSearchParams('', '', shopUrl, ui.values[0], ui.values[1]);
                }
            });

            // Display initial price values
            $("#minPriceDisplay").text($("#price-slider").slider("values", 0));
            $("#maxPriceDisplay").text($("#price-slider").slider("values", 1));
        });

        function updateSearchParams(searchParam, searchValue, route, priceMin, priceMax) {
            var url;
            console.log(searchValue)

            if (window.location.pathname !== "/shops" || (new URL(route)).pathname == '/vendors') {
                url = new URL(route);
            } else {
                url = new URL(window.location.href);
            }

            url.searchParams.set(searchParam, searchValue);

            // Set the price range parameters if provided
            if (priceMin !== undefined) {
                url.searchParams.set('priceMin', priceMin);
            }

            if (priceMax !== undefined) {
                url.searchParams.set('priceMax', priceMax);
            }

            var existingParams = new URLSearchParams(window.location.search);
            existingParams.delete(searchParam);

            // Remove existing price range parameters
            existingParams.delete('priceMin');
            existingParams.delete('priceMax');

            existingParams.forEach((value, key) => {
                url.searchParams.set(key, value);
            });

            const newUrl = url.href;
            window.location = newUrl;
        }

        function removeSearchParam(searchParam, route) {
            var url;

            if (window.location.pathname !== "/shops" || (new URL(route)).pathname == '/vendors') {
                url = new URL(route);
            } else {
                url = new URL(window.location.href);
            }

            var existingParams = new URLSearchParams(window.location.search);
            existingParams.delete(searchParam);

            const newUrl = url.href.split('?')[0] + '?' + existingParams.toString();
            window.location = newUrl;
        }
    </script>
@endsection
