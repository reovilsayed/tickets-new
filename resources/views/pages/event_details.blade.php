@extends('layouts.app')
@section('content')
    <section class="rooms1 section-padding">
        <div class="container">
            <div class="row ">
                <div class="col-md-5 event-details">

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
                <div x-data="{ tickets: {} }"
                    x-effect="$refs.total.innerText = 'Є'+(Object.values(tickets)).reduce((partialSum, a) => partialSum + a, 0)"
                    class="col-md-7 event-box">
                    <ul class="nav nav-pills sec-hd mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">
                                <div class="days">
                                    <p class="days-select">ALL</p>
                                    <p class="info-date">DATE</p>
                                    <span class="dot"></span>
                                </div>
                            </button>
                        </li>
                        @foreach ($event->dates() as $date)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-{{ $date }}" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false">
                                    <div class="days">
                                        <p class="days-select">{{ Carbon\Carbon::parse($date)->format('d') }}</p>
                                        <p class="info-date">{{ Carbon\Carbon::parse($date)->format('M') }}</p>
                                        <span class="dot"></span>
                                    </div>
                                </button>
                            </li>
                        @endforeach

                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        @foreach ($products as $key => $data)
                            <div class="tab-pane fade show @if ($loop->first) active @endif"
                                id="pills-{{ $key }}" role="tabpanel" aria-labelledby="pills-home-tab">
                                @foreach ($data as $product)
                                    <div :class="tickets[{{$product->id}}] ? 'card card-ticket active' : 'card card-ticket'  ">
                                        <div class="card-body tick">
                                            <div class="ticket-info">
                                                <div class="t-info">
                                                    <p class="t-date">
                                                        {{ collect($product->dates)->map(fn($date) => Carbon\Carbon::parse($date)->format('d M'))->implode(', ') }}
                                                    </p>
                                                    <p class="t-title">{{ $product->name }}</p>
                                                    <p class="t-des">{{ $product->description }}
                                                    </p>
                                                    @if ($product->sold_out)
                                                        <span class="sold">SOLD</span>
                                                    @endif
                                                </div>
                                                <div class="t-prize">
                                                    <span
                                                        class="text-dark me-2 ticket-prize">{{ Sohoj::price($product->currentPrice()) }}</span>
                                                    <select name="tickets[$product->id]" @if ($product->sold_out)
                                                        disabled
                                @endif
                                data-price="{{ $product->currentPrice() }}" min="0"
                                max="{{ $product->quantity }}"
                                x-on:change="tickets[{{ $product->id }}]={{ $product->currentPrice() }}* $el.value"
                                class="ticket-select"
                                x-model="category"
                                >
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                </select>
                            </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        @endforeach
        </div>
        <button class="event-buttton">
            <span>Confirmed</span>
            <span id="totalPrice" x-ref="total"> <i class="fa fa-arrow-right"></i></span>
        </button>

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
