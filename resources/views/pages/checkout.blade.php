@php
    $states = ['Capital Region of Denmark', 'Central Denmark Region', 'North Denmark Region', 'Region Zealand', 'Region of Southern Denmark	'];
@endphp

@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/css/style.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/slick.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">
    <style>
        .navbar .navbar-nav .nav-link {
            color: black;
        }
    </style>
@endsection
@section('content')
    <!-- Ec checkout page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <form class="" action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row justify-content-between">
                    <div class="ec-checkout-leftside col-lg-7 col-md-12 ">
                        <!-- checkout content Start -->
                        <div class="ec-checkout-content">
                            <div class="ec-checkout-inner">
                                <div class="ec-checkout-wrap margin-bottom-30">

                                    <div class="">
                                        {{-- <h3 >Enter order information </h3> --}}
                                        <div class=""style="background-color:#F8F5F0;">

                                            <input type="hidden" name="shop_id" value="">

                                            <fieldset class="p-4">
                                                <h3 class="ec-checkout-title mb-3" style="font-size: 20px;">{{ __('personal_info') }}
                                                </h3>
                                                <div class="row">
                                                    <div class=" col-md-6">

                                                        <input type="text"
                                                            class="bg-white ps-2 @error('first_name') is-invalid @enderror"
                                                            value="{{ Auth()->user() ? Auth()->user()->name : '' }}"
                                                            name="first_name" placeholder="{{ __('first_name') }} *" id="inputEmail4">
                                                        @error('first_name')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">

                                                        <input type="text" placeholder="{{ __('last_name') }} *"
                                                            value="{{ Auth()->user() ? Auth()->user()->l_name : '' }}"
                                                            name="last_name"
                                                            class="bg-white ps-2 @error('last_name') is-invalid @enderror"
                                                            id="inputPassword4">
                                                        @error('last_name')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-6">

                                                        <input type="email"
                                                            class="bg-white ps-2 @error('email') is-invalid @enderror"
                                                            value="{{ Auth()->user() ? Auth()->user()->email : '' }}"
                                                            name="email" id="inputAddress" placeholder="{{ __('email') }} *">
                                                        @error('email')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-6">

                                                        <input type="text"
                                                            class="bg-white ps-2 @error('phone') is-invalid @enderror"
                                                            value="{{ Auth()->user() ? Auth()->user()->phone : '' }}" name="phone" id="phone"
                                                            placeholder="{{ __('phone') }} *">
                                                        @error('phone')
                                                            <span class="text-danger">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                   

                                                </div>
                                            </fieldset>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="ec-checkout-rightside  col-lg-4 col-md-12 ">
                        <div class="ec-sidebar-wrap order-side border-0" style="background-color:#f8f5f0;border-radius:0px">
                            <!-- Sidebar Summary Block -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">{{ __('order_summery') }}</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <div class="ec-checkout-summary">
                                        @php
                                            $flatCharge = Sohoj::flatCommision(Sohoj::newItemTotal()) - Sohoj::newItemTotal();
                                            $tax = Sohoj::tax();
                                            $prices = Sohoj::newItemTotal();
                                        @endphp
                                        <div>
                                            <span class="text-left">{{ __('items') }}({{ Cart::getTotalQuantity() }}):</span>
                                            <span class="text-right">{{ Sohoj::price($prices) }}</span>
                                        </div>
                                      
                                        <div>
                                            <span class="text-left">{{ __('tax') }}:</span>
                                            <span class="text-right">{{ Sohoj::price($tax) }}</span>
                                        </div>
                                        @if (session()->has('discount'))
                                            <div>
                                                <span class="text-left">{{ __('discount') }}:</span>
                                                <span class="text-right">{{ Sohoj::price(Sohoj::discount()) }}</span>
                                            </div>
                                        @endif


                                        <div class="ec-checkout-summary-total">
                                            <span class="text-left order-title" style="font-size: 20px !important;">{{ __('order_total') }}:</span>
                                            <span class="text-right"
                                                style="font-weight: 800 !important;">{{ Sohoj::price($prices + $tax + $flatCharge - Sohoj::discount()) }}</span>
                                        </div>
                                        <div class="d-flex">

                                            <input type="checkbox" required class="@error('terms') is-invalid @enderror"
                                                id="terms" style="width: 25px;" value="1" name="terms"
                                                required><a href="#" style="" class="mt-3 ms-3">{!! __('terms & policy') !!}</span></a><span class="checked"></span>
                                            @error('terms')
                                                <span class="invalid-feedback " role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 justify-content-center" style="margin-top: 17px; ">
                                            <button class="butn-dark2" style="" type="submit"><span>{{ __('place_order') }}</span> </button>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <!-- Sidebar Summary Block -->
                        </div>
                        <div class="shipment-text  text-white" style="border-radius: 0px">
                            <span>{!! __('checkout_cart_footer') !!} <a href="" target="_blank"><u class="text-white">{{ __('learn_more') }}</u></a></span>

                        </div>

                    </div>
            </form>
        </div>


       
        </fieldset>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Personal Information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('user.address.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">

                                <input type="text" name="address_1" value="" required
                                    class="form-control mb-2 @error('address_1') is-invalid @enderror" id="inputAddress"
                                    placeholder="Street Address">
                                @error('address_1')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-12">

                                <input type="text" name="address_2" placeholder="Address 2" required
                                    class="form-control mb-2 @error('address_2') is-invalid @enderror" value=""
                                    id="inputAddress2">
                                @error('address_2')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="col-md-6">

                                <x-country />
                            </div>
                            <div class="col-md-6">

                                <x-state />
                            </div> --}}
                            <div class="col-md-6">

                                <input type="text" placeholder="City" required value="" name="city"
                                    class="form-control my-2 @error('city') is-invalid @enderror" id="inputPassword4">
                                @error('city')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" required
                                    class="form-control my-2 @error('post_code') is-invalid @enderror" value=""
                                    name="post_code" placeholder="Zip/Postal Code" id="inputEmail4">
                                @error('post_code')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
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

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                if (error?.setup_intent) {
                    document.getElementById('paymentmethod').value = error.setup_intent.payment_method
                    document.getElementById('paymentmethod').checked = true
                    document.getElementById('card-button').style.display = 'none'
                    toastr.success('Card added');
                } else {
                    toastr.error('Something went wrong. Try again letter');
                }

            } else {
                document.getElementById('paymentmethod').value = setup_intent.payment_method
                document.getElementById('paymentmethod').checked = true
                document.getElementById('card-button').style.display = 'none'
                toastr.success('Card added');
            }
        });
    </script>
@endsection
