@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/style.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/slick.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/frontend-assetss/responsive.css') }}" />
    <link rel="stylesheet" id="bg-switcher-css" href="{{ asset('assets/frontend-assetss/css/backgrounds/bg-4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/order_page.css') }}">
@endsection
@section('content')
    <x-app.header />
    <!-- Product area start -->
    <div class="container">
        <div class="col-12">
            <div class="container title-margin">
                <h2>Order detail page</h2>

            </div>
            <div class="container-fluid d-flex justify-content-between align-items-center order-heading p-3">
                <h3 class="text-white">Pending Orders</h3>
                <p>Order date: 11/12/22</p>
            </div>
            <div class="col-md-12">
                <div class="cart-item card rounded-4">
                    <div class="card-body row box-shadow d-flex justify-content-between align-items-center">

                        <div class="col-md-8 row">
                            <div class="col-md-5 center">
                                <img class="cart-item-image" src="{{ asset('assets/img/cart/pizza.jpeg') }}" alt="">
                            </div>
                            <div class="col-md-6  cart-item-text">
                                <h4 class="font-size">Large Cheese Pizza</h4>
                                <p class="item-title">Pump, Energy, And Strength With Caffeine, Nitrates, And
                                    Theobromine</p>
                                <strong class="text-dark"><span>Paid:</span><span>$39.99 <br></span></strong>

                                <a href="" class="btn btn-light border rounded my-3" type="submit">Cancel order</a>


                            </div>
                        </div>
                        <div class="col-md-4  ">
                            <div class="ec-sidebar-block  side-bar-box ">

                                <div class="ec-sb-block-content">
                                    <div class="">
                                        <div class=" p-4 border rounded-3">


                                            <div class="text-center">
                                                <h6>Tracking number <br></h6>


                                                <h6 class="border-custom px-4">0673487953745987593 <br></h6>
                                            </div>


                                            <h6 class="mt-3">Order status: <span class="text-success">On its way!</span>
                                                <br>
                                            </h6>


                                            <h6>Arriving: <span class="text-success">Monday, Jan 28 </span> </h6>





                                        </div>
                                        <h5 class="text-center"><a class="message-color" href=""> Contact the
                                                seller?</a>
                                        </h5>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="cart-item card rounded-4">
                    <div class="card-body row box-shadow d-flex justify-content-between align-items-center">

                        <div class="col-md-8 row">
                            <div class="col-md-5 center">
                                <img class="cart-item-image" src="{{ asset('assets/img/cart/pizza.jpeg') }}" alt="">
                            </div>
                            <div class="col-md-6  cart-item-text">
                                <h4 class="font-size">Large Cheese Pizza</h4>
                                <p class="item-title">Pump, Energy, And Strength With Caffeine, Nitrates, And
                                    Theobromine</p>
                                <strong class="text-dark"><span>Paid:</span><span>$39.99 <br></span></strong>

                                <a href="" class="btn btn-light border rounded my-3" type="submit">Cancel order</a>


                            </div>
                        </div>
                        <div class="col-md-4  ">
                            <div class="ec-sidebar-block  side-bar-box ">

                                <div class="ec-sb-block-content">
                                    <div class="">
                                        <div class=" p-4 border rounded-3">


                                            <div class="text-center">
                                                <h6>Tracking number <br></h6>


                                                <h6 class="border-custom px-4">0673487953745987593 <br></h6>
                                            </div>


                                            <h6 class="mt-3">Order status: <span class="text-success">On its way!</span>
                                                <br>
                                            </h6>


                                            <h6>Arriving: <span class="text-success">Monday, Jan 28 </span> </h6>





                                        </div>
                                        <h5 class="text-center"><a class="message-color" href=""> Contact the
                                                seller?</a>
                                        </h5>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
        <div class="col-12 mb-5">

            <div
                class="container-fluid d-flex justify-content-between align-items-center order-heading order-heading-previous p-3">
                <h3 class="text-white">Previous order history</h3>
                <a href="#" class="text-white border-rounded p-2"><i class="fi-rr-calendar-lines">&nbsp;</i>Filter</a>
            </div>
            <div class="col-md-12">
                <div class="cart-item card rounded-4">
                    <div class="card-body row box-shadow d-flex justify-content-between align-items-center">

                        <div class="col-md-8 row">
                            <div class="col-md-5 center">
                                <img class="cart-item-image" src="{{ asset('assets/img/cart/pizza.jpeg') }}" alt="">
                            </div>
                            <div class="col-md-6  cart-item-text">
                                <h4 class="font-size">Large Cheese Pizza</h4>
                                <p class="item-title">Pump, Energy, And Strength With Caffeine, Nitrates, And
                                    Theobromine</p>
                                <strong class="text-dark"><span>Paid:</span><span>$39.99 <br></span></strong>

                                <a href="" class="btn btn-light border rounded my-3" type="submit">Return or replace
                                    order</a>


                            </div>
                        </div>
                        <div class="col-md-4  ">
                            <div class="ec-sidebar-block  side-bar-box ">

                                <div class="ec-sb-block-content">
                                    <div class="">
                                        <div class=" p-4 border rounded-3">


                                            <div class="text-center">
                                                <h6>Tracking number <br></h6>


                                                <h6 class="border-custom px-4">0673487953745987593 <br></h6>
                                            </div>


                                            <h6 class="mt-3">Order status: <span class="text-success">On its way!</span>
                                                <br>
                                            </h6>


                                            <h6>Arriving: <span class="text-success">Monday, Jan 28 </span> </h6>





                                        </div>
                                        <h5 class="text-center"><a class="message-color" href=""> Contact the
                                                seller?</a>
                                        </h5>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="cart-item card rounded-4">
                    <div class="card-body row box-shadow d-flex justify-content-between align-items-center">

                        <div class="col-md-8 row">
                            <div class="col-md-5 center">
                                <img class="cart-item-image" src="{{ asset('assets/img/cart/pizza.jpeg') }}"
                                    alt="">
                            </div>
                            <div class="col-md-6  cart-item-text">
                                <h4 class="font-size">Large Cheese Pizza</h4>
                                <p class="item-title">Pump, Energy, And Strength With Caffeine, Nitrates, And
                                    Theobromine</p>
                                <strong class="text-dark"><span>Paid:</span><span>$39.99 <br></span></strong>

                                <a href="" class="btn btn-light border rounded my-3" type="submit">Return or
                                    replace
                                    order</a>


                            </div>
                        </div>
                        <div class="col-md-4  ">
                            <div class="ec-sidebar-block  side-bar-box ">

                                <div class="ec-sb-block-content">
                                    <div class="">
                                        <div class=" p-4 border rounded-3">


                                            <div class="text-center">
                                                <h6>Tracking number <br></h6>


                                                <h6 class="border-custom px-4">0673487953745987593 <br></h6>
                                            </div>


                                            <h6 class="mt-3">Order status: <span class="text-success">On its way!</span>
                                                <br>
                                            </h6>


                                            <h6>Arriving: <span class="text-success">Monday, Jan 28 </span> </h6>





                                        </div>
                                        <h5 class="text-center"><a class="message-color" href=""> Contact the
                                                seller?</a>
                                        </h5>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="cart-item card rounded-4">
                    <div class="card-body row box-shadow d-flex justify-content-between align-items-center">

                        <div class="col-md-8 row">
                            <div class="col-md-5 center">
                                <img class="cart-item-image" src="{{ asset('assets/img/cart/pizza.jpeg') }}"
                                    alt="">
                            </div>
                            <div class="col-md-6  cart-item-text">
                                <h4 class="font-size">Large Cheese Pizza</h4>
                                <p class="item-title">Pump, Energy, And Strength With Caffeine, Nitrates, And
                                    Theobromine</p>
                                <strong class="text-dark"><span>Paid:</span><span>$39.99 <br></span></strong>

                                <a href="" class="btn btn-light border rounded my-3" type="submit">Return or
                                    replace
                                    order</a>


                            </div>
                        </div>
                        <div class="col-md-4  ">
                            <div class="ec-sidebar-block  side-bar-box ">

                                <div class="ec-sb-block-content">
                                    <div class="">
                                        <div class=" p-4 border rounded-3">


                                            <div class="text-center">
                                                <h6>Tracking number <br></h6>


                                                <h6 class="border-custom px-4">0673487953745987593 <br></h6>
                                            </div>


                                            <h6 class="mt-3">Order status: <span class="text-success">On its way!</span>
                                                <br>
                                            </h6>


                                            <h6>Arriving: <span class="text-success">Monday, Jan 28 </span> </h6>





                                        </div>
                                        <h5 class="text-center"><a class="message-color" href=""> Contact the
                                                seller?</a>
                                        </h5>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="cart-item card rounded-4">
                    <div class="card-body row box-shadow d-flex justify-content-between align-items-center">

                        <div class="col-md-8 row">
                            <div class="col-md-5 center">
                                <img class="cart-item-image" src="{{ asset('assets/img/cart/pizza.jpeg') }}"
                                    alt="">
                            </div>
                            <div class="col-md-6  cart-item-text">
                                <h4 class="font-size">Large Cheese Pizza</h4>
                                <p class="item-title">Pump, Energy, And Strength With Caffeine, Nitrates, And
                                    Theobromine</p>
                                <strong class="text-dark"><span>Paid:</span><span>$39.99 <br></span></strong>

                                <a href="" class="btn btn-light border rounded my-3" type="submit">Return or
                                    replace
                                    order</a>


                            </div>
                        </div>
                        <div class="col-md-4  ">
                            <div class="ec-sidebar-block  side-bar-box ">

                                <div class="ec-sb-block-content">
                                    <div class="">
                                        <div class=" p-4 border rounded-3">


                                            <div class="text-center">
                                                <h6>Tracking number <br></h6>


                                                <h6 class="border-custom px-4">0673487953745987593 <br></h6>
                                            </div>


                                            <h6 class="mt-3">Order status: <span class="text-success">On its way!</span>
                                                <br>
                                            </h6>


                                            <h6>Arriving: <span class="text-success">Monday, Jan 28 </span> </h6>





                                        </div>
                                        <h5 class="text-center"><a class="message-color" href=""> Contact the
                                                seller?</a>
                                        </h5>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="cart-item card rounded-4">
                    <div class="card-body row box-shadow d-flex justify-content-between align-items-center">

                        <div class="col-md-8 row">
                            <div class="col-md-5 center">
                                <img class="cart-item-image" src="{{ asset('assets/img/cart/pizza.jpeg') }}"
                                    alt="">
                            </div>
                            <div class="col-md-6  cart-item-text">
                                <h4 class="font-size">Large Cheese Pizza</h4>
                                <p class="item-title">Pump, Energy, And Strength With Caffeine, Nitrates, And
                                    Theobromine</p>
                                <strong class="text-dark"><span>Paid:</span><span>$39.99 <br></span></strong>

                                <a href="" class="btn btn-light border rounded my-3" type="submit">Return or
                                    replace
                                    order</a>


                            </div>
                        </div>
                        <div class="col-md-4  ">
                            <div class="ec-sidebar-block  side-bar-box ">

                                <div class="ec-sb-block-content">
                                    <div class="">
                                        <div class=" p-4 border rounded-3">


                                            <div class="text-center">
                                                <h6>Tracking number <br></h6>


                                                <h6 class="border-custom px-4">0673487953745987593 <br></h6>
                                            </div>


                                            <h6 class="mt-3">Order status: <span class="text-success">On its way!</span>
                                                <br>
                                            </h6>


                                            <h6>Arriving: <span class="text-success">Monday, Jan 28 </span> </h6>





                                        </div>
                                        <h5 class="text-center"><a class="message-color" href=""> Contact the
                                                seller?</a>
                                        </h5>

                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- product area end -->
@endsection
@section('js')
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
@endsection
