@extends('layouts.app')
@section('css')
    <style>
        .coupon-form div {
            display: grid;
            grid-template-columns: 4fr 1fr;
        }

        .coupon-form input {
            %;
            height: 40px;
            padding: 10px;
            border: 1px solid #f36a30;

        }

        .coupon-form button {
            box-shadow: 0px 0px #f36a30;
            height: 40px;
            border: 1px solid #f36a30;
            border-left: none;
            transition: 1s cubic-bezier(0.075, 0.82, 0.165, 1);
        }

        .coupon-form button:hover {
            background-color: #f36b306d;
            box-shadow: 5px 5px #f36a30;

        }

        .event-box {
            height: 700px;
            overflow: scroll;
            background-color: #fff !important;
        }

        .accordion-button:not(.collapsed) {

            background-color: #ef5411b2;

        }

        .accordion-button {

            color: #fff !important;
            font-weight: 600;
            padding: 10px 20px;
            background-color: #ef5411b2;
        }

        .accordion-body {
            border: none;
        }
    </style>
@endsection
@section('content')
    <section class="rooms1 section-padding">
        <div class="container">
            <div class="row ">
                <div class="col-md-4 event-details">

                    <div class="event_img">
                        <img src=" {{ Voyager::image($event->thumbnail) }}" alt="">
                    </div>

                    <h2 class="events-title mt-2 px-3 text-center">{{ $event->name }}</h2>
                    <div class="accordins">
                        <div class="accordin-item">
                            <div>
                                <i class="fa fa-calendar fa-2x"></i>
                            </div>
                            <div>
                                <h5>
                                    {{ __('words.start_at') }} {{ $event->start_at->diffForHumans() }}
                                </h5>
                                <h6>
                                    {{ $event->start_at->format('d M') }}
                                </h6>
                                <h6>
                                    {{ $event->start_at->format('H:i') }}

                                </h6>
                            </div>
                        </div>
                        <div class="accordin-item">
                            <div>
                                <i class="fa fa-location-pin fa-2x"></i>
                            </div>
                            <div>
                                <h5>
                                    {{ $event->location }}
                                </h5>

                            </div>
                        </div>
                        <div class="accordin-item">
                            <div>
                                <i class="fa fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5>
                                    {{ __('words.description') }}
                                </h5>
                                <p>
                                    {!! $event->description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 event-box">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0">{{ __('words.hello,') }} {{ auth()->user()->name }}</h3>
                                    <p>{{ auth()->user()->contact_number }}</p>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">

                                    @if (!session()->has('discount'))
                                        <div>
                                            <h5>
                                                {{ __('words.apply_cupon_code') }}
                                            </h5>
                                        </div>

                                        <form class="coupon-form" name="ec-cart-coupan-form" method="POST"
                                            action="{{ route('coupon', ['event' => $event->slug]) }}">
                                            @csrf
                                            <div class="">
                                                <input type="text" required
                                                    placeholder="{{ __('words.enter_your_coupan_code') }}"
                                                    name="coupon_code" value="">
                                                <button type="submit"><span>{{ __('words.apply') }}</span></button>
                                            </div>
                                        </form>
                                    @endif
                                    <h3 class="dashboard-title mb-3">
                                        {{ __('words.order_summary') }}
                                    </h3>
                                    <table class="table">
                                        <tr>
                                            <th>
                                                {{ __('words.ticket') }}
                                            </th>
                                            <th>
                                                {{ __('words.quantity') }}
                                            </th>
                                            <th>
                                                {{ __('words.price') }}
                                            </th>
                                            <th>
                                                {{ __('words.total') }}
                                            </th>
                                        </tr>
                                        @php
                                            $coupon = App\Models\Coupon::where(
                                                'code',
                                                session()->get('discount_code'),
                                            )->first();
                                            $items = Cart::session($event->slug)->getContent();
                                            if ($coupon) {
                                                $discountedProduct = $items->filter(
                                                    fn($item) => $coupon->getProducts()->contains($item->id),
                                                );
                                                $discountPerUnit = number_format(
                                                    session()->get('discount') / $discountedProduct->sum('quantity'),
                                                    4,
                                                );
                                            } else {
                                                $discountedProduct = collect([]);
                                                $discountPerUnit = 0;
                                            }

                                        @endphp

                                        @foreach ($items as $key => $cart)
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
                                                <td>
                                                    {{ Sohoj::price($cart->quantity * $cart->price) }} @if (isset($discountedProduct[$key]))
                                                        <small class="text-danger"> - {{ Sohoj::price($discountPerUnit * $cart->quantity) }}</small>
                                                    @endif
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

                                                <span class="h6 uppercase"> {{ __('words.subtotal') }}:</span>
                                            </th>
                                            <th>
                                                <span class="h6">
                                                    {{ Sohoj::price(Cart::getTotal()) }}
                                                </span>
                                            </th>
                                        </tr>

                                        @if (session()->has('discount'))
                                            <tr>
                                                <th>

                                                </th>
                                                <th>
                                                    <span class="h6 uppercase"> {{ __('words.discount') }}:</span> <a
                                                        class="text-danger" href="{{ route('coupon.destroy') }}">
                                                        {{ __('words.remove_coupon') }}</a>
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
                                                <span class="h4"> {{ __('words.total') }}:</span>
                                            </th>
                                            <th>
                                                <span class="h4">
                                                    {{ Sohoj::price(Cart::getTotal() - Sohoj::discount()) }}
                                                </span>
                                            </th>
                                        </tr>
                                    </table>
                                    <form method="post" action="{{ route('checkout.store', $event) }}">
                                        @csrf
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item bg-transparent">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                        aria-expanded="false" aria-controls="collapseOne">
                                                        {{ __('words.billing_info') }}
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">

                                                        <div class="mb-3">
                                                            <label for="vatNumber" class="form-label">
                                                                {{ __('words.vat_number') }}</label>
                                                            <input type="text" name="vatNumber" class="form-control"
                                                                id="vatNumber" value="{{ auth()->user()->vatNumber }}"
                                                                placeholder="{{ __('words.vat_number') }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="name"
                                                                class="form-label">{{ __('words.name') }}</label>
                                                            <input type="text" name="name" class="form-control"
                                                                id="name" placeholder="{{ __('words.enter_name') }}"
                                                                value="{{ auth()->user()->name . ' ' . auth()->user()->l_name }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="address"
                                                                class="form-label">{{ __('words.address') }}</label>
                                                            <input type="text" name="address" class="form-control"
                                                                id="address"
                                                                placeholder="{{ __('words.enter_address') }}"
                                                                value="{{ auth()->user()->address }}">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit"
                                            class="btn btn-primary mt-3">{{ __('words.proceed_to_payment') }}</button>
                                        <button class="">
                                            <a href="#" class="btn btn-primary mt-3"
                                                onclick="history.back();return false;"> <i
                                                    class="fa-solid fa-chevron-left"></i> {{ __('words.go_back') }}</a>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
@endsection
