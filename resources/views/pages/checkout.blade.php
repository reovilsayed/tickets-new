@extends('layouts.app')
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
                                        Start in {{ $event->start_at->diffForHumans() }}
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
                                        Description
                                    </h5>
                                    <p>
                                        {{ $event->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-data="{ tickets: {}, quantities: {} }"
                        x-effect="$refs.total.innerText = 'Є'+(Object.values(tickets)).reduce((partialSum, a) => partialSum + a, 0)"
                        class="col-md-8 event-box">
                        <div class="row">
                           
                            <div class="col-md-6">
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
                                            @foreach (Cart::getContent() as $cart)
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
                                                        {{ Sohoj::price(Cart::getTotal()) }}
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
                                                        {{ Sohoj::price(Cart::getTotal() - Sohoj::discount()) }}
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

                </div>
            </div>
        </section>

@endsection
@section('js')
    <script defer src="{{ asset('assets/js/alpine.js') }}"></script>
    <script>
        let data = Alpine.reactive({
            tickets: {}
        })
        Alpine.effect(() => {
            console.log(data.tickets);
        })
    </script>
@endsection
