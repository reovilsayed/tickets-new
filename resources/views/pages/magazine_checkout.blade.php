@extends('layouts.app')
@section('title', $magazine->title)
@section('meta_description', $magazine->meta_description)
@section('keywords', $magazine->keywords)
@section('css')
<style>
    .coupon-form div {
        display: grid;
        grid-template-columns: 4fr 1fr;
    }
    .coupon-form input {
        width: 100%;
        height: 40px;
        padding: 10px;
        border: 1px solid #28BADF;
    }
    .coupon-form button {
        box-shadow: 0px 0px #28BADF;
        height: 40px;
        border: 1px solid #28BADF;
        border-left: none;
        transition: 1s cubic-bezier(0.075, 0.82, 0.165, 1);
    }
    .coupon-form button:hover {
        background-color: #28BADF;
        box-shadow: 5px 5px #28BADF;
    }
    .event-box {
        height: 700px;
        overflow: scroll;
        background-color: #fff !important;
    }
    .accordion-button:not(.collapsed) {
        background-color: #28BADF;
    }
    .accordion-button {
        color: #fff !important;
        font-weight: 600;
        padding: 10px 20px;
        background-color: #28BADF;
    }
    .accordion-body {
        border: none;
    }
    .dashboard-title {
        color: #28BADF !important;
    }
    .price-summary {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-top: 20px;
    }
    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .total-row {
        font-weight: bold;
        font-size: 1.2rem;
        border-top: 1px solid #ddd;
        padding-top: 10px;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
@php
    // Initialize all variables at the beginning
    $items = Cart::session($magazine->slug)->getContent();
    $subtotal = Cart::session($magazine->slug)->getTotal();
    $discount = session('discount', 0);
    $showBillingInfo = false;
    $coupon = null;
    $discountPerUnit = 0;
    
    // Check for physical items
    foreach ($items as $item) {
        if ($item->attributes->get('subscription_type') === 'physical') {
            $showBillingInfo = true;
            break;
        }
    }
    
    // Coupon logic
    if (session('discount_code')) {
        $coupon = \App\Models\MagazineCoupon::where('code', session('discount_code'))
            ->where('magazine_id', $magazine->id)
            ->first();
        
        if ($coupon) {
            $totalQuantity = $items->sum('quantity');
            $discountPerUnit = $totalQuantity > 0 
                ? number_format($discount / $totalQuantity, 4)
                : 0;
        }
    }
@endphp

<section class="rooms1 section-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-4 event-details d-none d-md-block">
                <div class="event_img">
                    <img src="{{ Voyager::image($magazine->image) }}" alt="">
                </div>
                <h2 class="events-title mt-2 px-3 text-center">{{ $magazine->name }}</h2>
                <div class="accordins">
                    <div class="accordin-item">
                        <div>
                            <i class="fa fa-info-circle fa-2x" style="color: #28BADF;"></i>
                        </div>
                        <div>
                            <h5>{{ __('words.description') }}</h5>
                            <p>{!! $magazine->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8 event-box">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0" style="color: #28BADF">{{ __('words.hello,') }} {{ auth()->user()->name }}</h3>
                                <p>{{ auth()->user()->contact_number }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @if (!session()->has('discount'))
                                    <div class="coupon-section">
                                        <h5 style="color: #28BADF">{{ __('words.apply_cupon_code') }}</h5>
                                        <form class="coupon-form" method="POST" action="{{ route('magazine.coupon', $magazine->slug) }}">
                                            @csrf
                                            <input type="text" required name="coupon_code" placeholder="{{ __('words.enter_your_coupan_code') }}">
                                            <button type="submit">{{ __('words.apply') }}</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="applied-coupon">
                                        <span>{{ session('discount_code') }}</span>
                                        <a href="{{ route('magazine.coupon.remove', $magazine->slug) }}" class="remove-coupon">
                                            {{ __('words.remove') }}
                                        </a>
                                    </div>
                                @endif
                                
                                <h3 class="dashboard-title mb-3" style="color: #28BADF">{{ __('words.order_summary') }}</h3>
                                
                                <table class="table">
                                    <tr>
                                        <th>{{ __('words.name') }}</th>
                                        <th>{{ __('words.quantity') }}</th>
                                        <th>{{ __('words.price') }}</th>
                                        <th>{{ __('words.total') }}</th>
                                    </tr>

                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>X {{ $item->quantity }}</td>
                                            <td>{{ Sohoj::price($item->price) }}</td>
                                            <td>
                                                {{ Sohoj::price($item->quantity * $item->price) }}
                                                @if($coupon)
                                                    <small class="text-danger"> - {{ Sohoj::price($discountPerUnit * $item->quantity) }}</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>

                                <div class="price-summary">
                                    <div class="price-row">
                                        <span>{{ __('words.subtotal') }}:</span>
                                        <span>{{ Sohoj::price($subtotal) }}</span>
                                    </div>
                                    
                                    @if(session('discount'))
                                    <div class="price-row text-danger">
                                        <span>{{ __('words.discount') }} ({{ session('discount_code') }}):</span>
                                        <span>- {{ Sohoj::price($discount) }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($showBillingInfo)
                                    <div class="price-row shipping-row">
                                        <span>{{ __('words.shipping') }}:</span>
                                        <span id="shipping-price">$0.00</span>
                                    </div>
                                    @endif
                                    
                                    <div class="price-row total-row">
                                        <span>{{ __('words.total') }}:</span>
                                        <span id="calculated-total">{{ Sohoj::price($subtotal - $discount) }}</span>
                                    </div>
                                </div>

                                <form method="post" action="{{ route('magazinecheckout.store', $magazine) }}">
                                    @csrf
                                    <input type="hidden" name="coupon_code" value="{{ session('discount_code') }}">
                                    <input type="hidden" name="discount_amount" value="{{ $discount }}">
                                    
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item bg-transparent">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                    aria-expanded="false" aria-controls="collapseOne"
                                                    style="background-color: #28BADF;">
                                                    {{ __('words.billing_info') }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="mb-3">
                                                        <label for="vatNumber" class="form-label">{{ __('words.vat_number') }}</label>
                                                        <input type="text" name="vatNumber" class="form-control"
                                                            id="vatNumber" value="{{ auth()->user()->vatNumber }}"
                                                            placeholder="{{ __('words.vat_number') }}">
                                                    </div>
                                                    <div class="mb-3 row row-cols-2">
                                                        <div>
                                                            <label for="name" class="form-label">{{ __('words.name') }}</label>
                                                            <input type="text" name="name" class="form-control"
                                                                id="name" placeholder="{{ __('words.enter_name') }}"
                                                                value="{{ auth()->user()->name }}">
                                                        </div>
                                                        <div>
                                                            <label for="l_name" class="form-label">{{ __('words.name') }}</label>
                                                            <input type="text" name="l_name" class="form-control"
                                                                id="l_name" placeholder="{{ __('words.enter_name') }}"
                                                                value="{{ auth()->user()->l_name }}">
                                                        </div>
                                                    </div>
                                                    <label for="intl-phone" class="form-label">{{ __('words.contact_number') }}</label>
                                                    <div class="mb-3">
                                                        <input type="tel" name="contact_number" class="form-control"
                                                            id="intl-phone" placeholder="{{ __('words.contact_number') }}"
                                                            value="{{ auth()->user()->contact_number }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="address" class="form-label">{{ __('words.address') }}</label>
                                                        <input type="text" name="address" class="form-control"
                                                            id="address" placeholder="{{ __('words.enter_address') }}"
                                                            value="{{ auth()->user()->address }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($showBillingInfo)
                                        <div class="accordion-item bg-transparent">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo"
                                                    style="background-color: #28BADF;">
                                                    {{ __('words.shipping_info') }}
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse"
                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="country" class="form-label">{{ __('words.country') }}</label>
                                                            <input type="text" name="country" class="form-control"
                                                                id="country" placeholder="{{ __('words.country') }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="country_code" class="form-label">{{ __('words.country_code') }}</label>
                                                            <input type="text" name="country_code"
                                                                class="form-control" id="country_code"
                                                                placeholder="{{ __('words.country_code') }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="price" class="form-label">{{ __('words.price') }}</label>
                                                            <input type="number" step="0.01" name="price"
                                                                class="form-control" id="price"
                                                                placeholder="{{ __('words.price') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex justify-content-between mt-4">
                                        <a href="{{ url()->previous() }}" class="btn" style="background-color: #28BADF; color: #ffff">
                                            <i class="fa-solid fa-chevron-left"></i> {{ __('words.go_back') }}
                                        </a>
                                        <button type="submit" class="btn" style="background-color: #28BADF; color: #ffff">
                                            {{ __('words.proceed_to_payment') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countryInput = document.getElementById('country');
        const priceInput = document.getElementById('price');
        const shippingPriceDisplay = document.getElementById('shipping-price');
        const totalDisplay = document.getElementById('calculated-total');
        
        const subtotal = parseFloat("{{ $subtotal }}") || 0;
        const discount = parseFloat("{{ $discount }}") || 0;

        function updateTotal(shipping = 0) {
            const total = (subtotal - discount + shipping);
            if (shippingPriceDisplay) shippingPriceDisplay.textContent = 'Є' + shipping.toFixed(2);
            if (totalDisplay) totalDisplay.textContent = 'Є' + total.toFixed(2);
            if (priceInput) priceInput.value = shipping;
        }

        function fetchShippingPrice() {
            const country = countryInput.value;
            if (country) {
                fetch(`/get-shipping-price?country=${encodeURIComponent(country)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.price) {
                            updateTotal(parseFloat(data.price));
                        } else {
                            updateTotal(0);
                        }
                    });
            }
        }

        if (countryInput) {
            countryInput.addEventListener('change', fetchShippingPrice);
        }

        // Initialize
        updateTotal(0);
    });
</script>
@endsection