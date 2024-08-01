@php
    $states = [
        'Capital Region of Denmark',
        'Central Denmark Region',
        'North Denmark Region',
        'Region Zealand',
        'Region of Southern Denmark	',
    ];
@endphp

@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-assets/css/plugins/slick.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend-old-assets/responsive.css') }}" />
    <style>
        .navbar .navbar-nav .nav-link {
            color: black;
        }
    </style>
@endsection
@section('content')
    <form method="POST" action="{{ route('coupon') }}" id="coupon-form">
        @csrf

    </form>
    <form action="{{ route('checkout.store',$event) }}" method="post">
        @csrf
        <!-- Ec checkout page -->
        <section class="ec-page-content section-space-p">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <div class="card" style="box-shadow: 0px 10px 10px #000">
                            <div class="card-body">
                                <h3 class="dashboard-title">
                                    Billing information
                                </h3>
                                <div class="row mt-5">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="mb-0" for="first_name">First name</label>
                                            <input type="text" id="first_name" name="first_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label class="mb-0" for="last_name">Last name</label>
                                            <input type="text" id="last_name" name="last_name" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="mb-0" for="email">Email</label>
                                            <input type="email" id="email" name="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="mb-0" for="phone">Phone</label>
                                            <input type="text" id="phone" name="phone" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="mb-0" for="phone">Tax payer number</label>
                                            <input type="text" id="taxid" name="taxid" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                {{-- @if (!session()->has('discount'))
                                    <h6 class="dashboard-title">
                                        Apply coupon
                                    </h6>


                                    <div class="form-group  col-md-12 d-flex">
                                        <input class="form-control" type="text" required=""
                                            placeholder="Enter Your Coupan Code" id="coupon-input" value="">
                                        <button type="button" 
                                            type="submit" class="btn border btn-dark " style="margin-right: 0 !important"
                                            id="basic-addon2"><span>Apply</span></button>
                                    </div>
                                @endif --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card">

                            <div class="card-body">
                                <h3 class="dashboard-title mb-3">
                                    Order Information
                                </h3>
                                <table class="table">
                                    <tr>
                                        <th>
                                            Ticket
                                        </th>
                                        <th>
                                            Quantity
                                        </th>
                                        <th>
                                            Price
                                        </th>
                                    </tr>
                                    @foreach (Cart::session($event->slug)->getContent() as $cart)
                                        <tr>
                                            <th>
                                                {{ $cart->name }}
                                            </th>
                                            <td>
                                                X {{ $cart->quantity }}
                                            </td>
                                            <td>
                                                {{ Sohoj::price($cart->price) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th rowspan="2" colspan="3">

                                        </th>
                                    </tr>
                                    <tr>


                                    </tr>
                                    <tr>
                                        <th>

                                        </th>
                                        <th>

                                            <span class="h6 uppercase">Subtotal :</span>
                                        </th>
                                        <th>
                                            <span class="h6">
                                                {{ Sohoj::price(Cart::session($event->slug)->getTotal()) }}
                                            </span>
                                        </th>
                                    </tr>

                                    @if (session()->has('discount'))
                                        <tr>
                                            <th>

                                            </th>
                                            <th>

                                                <span class="h6 uppercase">Discount :</span>
                                            </th>
                                            <th>
                                                <span class="h6">
                                                    {{ Sohoj::price(Sohoj::discount()) }}
                                                </span>
                                            </th>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>

                                        </th>
                                        <th>
                                            <span class="h4">Total :</span>
                                        </th>
                                        <th>
                                            <span class="h4">
                                                {{ Sohoj::price(Cart::session($event->slug)->getTotal() - Sohoj::discount()) }}
                                            </span>
                                        </th>
                                    </tr>
                                </table>

                                <button class="btn btn-primary rounded ">
                                    <span class="mr-3">Go To Payment</span> <i class="fa fa-arrow-right"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </section>
    </form>
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
