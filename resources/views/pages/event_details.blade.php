@extends('layouts.app')
@section('content')
    @if ($is_invite)
        <form action="{{ route('invite.checkout', $invite) }}" method="post">
        @else
            <form action="{{ route('cart.store', $event) }}" method="post">
    @endif
    @csrf
    <section class="rooms1 section-padding">
        <div class="container">
            <div class="row ">
                <div class="col-md-5 event-details">

                    <div class="event_img">
                        <img src=" {{ Voyager::image($event->thumbnail) }}" alt="">
                    </div>

                    <h2 class="events-title mt-2 px-3 text-center">{{ $event->name }}</h2>
                    <div class="text-center d-md-none">
                        <a href="#mobile-device"><button
                                class="custom-button back-button">{{ __('words.envent_list') }}</button></a>
                    </div>
                    <div class="accordins">
                        <div class="accordin-item">
                            <div>
                                <i class="fa fa-calendar fa-2x"></i>
                            </div>
                            <div>
                                <h5>
                                    {{ __('words.start_in') }} {{ $event->start_at->diffForHumans() }}
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

                <div x-data="eventData" x-effect="calculateTotal()" class="col-md-7 event-box" id="mobile-device">

                    <ul class="nav nav-pills sec-hd mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">
                                <div class="days">
                                    <p class="days-select">{{ __('words.all') }}</p>
                                    <p class="info-date">{{ __('words.date') }}</p>
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
                                    @if ($product->status == 1 || $product->status == 2 || $product->status == 3 || $product->status == 4)
                                        <div
                                            :class="tickets[{{ $product->id }}] ? 'card card-ticket active' :
                                                'card card-ticket'">
                                            <div class="card-body tick">

                                                @if ($product->status == 2 || $product->quantity <= 0)
                                                    <span class="text-danger sold-sm">{{ __('words.sold') }}</span>
                                                @elseif($product->status == 4)
                                                    <span class="text-danger sold-sm">{{ __('words.soon') }}</span>
                                                @endif

                                                <p class="t-date">
                                                    {{ collect($product->dates)->map(fn($date) => Carbon\Carbon::parse($date)->format('d M'))->implode(', ') }}
                                                </p>

                                                <div class="ticket-info">
                                                    <div class="t-info">
                                                        <p class="t-title">{{ $product->name }} </p>
                                                        <p class="t-des">{!! $product->description !!}
                                                        </p>
                                                        @if ($product->status == 2 || $product->quantity <= 0)
                                                            <span class="sold d-none">{{ __('words.sold') }}</span>
                                                        @elseif($product->status == 4)
                                                            <span class="sold d-none">{{ __('words.soon') }}</span>
                                                        @endif
                                                    </div>
                                                    @if ($product->status == 3)
                                                        <div class="t-prize d-flex flex-column align-items-end">
                                                            @if (!$is_invite)
                                                                <span
                                                                    class="text-dark me-2 ticket-prize">{{ Sohoj::price($product->currentPrice()) }}</span>
                                                            @endif
                                                            <a target="__blank" class="btn custom-button d-none d-lg-block"
                                                                href="{{ $product->website }}">{{ __('words.visit_here') }}</a>
                                                        </div>
                                                    @else
                                                        <div class="t-prize">
                                                            @if (!$is_invite)
                                                                <span
                                                                    class="text-dark me-2 ticket-prize">{{ Sohoj::price($product->currentPrice()) }}</span>
                                                            @endif

                                                            @php
                                                                $limit =
                                                                    $product->limit_per_order > $product->quantity
                                                                        ? $product->quantity
                                                                        : $product->limit_per_order;

                                                                $quantity = !$is_invite
                                                                    ? $limit
                                                                    : ($product->pivot->quantity > $product->quantity
                                                                        ? $product->quantity
                                                                        : $product->pivot->quantity);
                                                            @endphp

                                                            @if ($product->status == 1 && $product->quantity > 0)
                                                                <select name="tickets[{{ $product->id }}]"
                                                                    @if ($product->sold_out) disabled @endif
                                                                    data-price="{{ $product->currentPrice() }}"
                                                                    min="0" max="{{ $product->quantity }}"
                                                                    class="ticket-select"
                                                                    x-model="quantities[{{ $product->id }}]"
                                                                    x-on:change="updateTicket({{ $product->id }},{{ $product->currentPrice() }})">
                                                                    <option value="0">0</option>
                                                                    @for ($i = 1; $i <= $quantity; $i++)
                                                                        <option value="{{ $i }}">
                                                                            {{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>

                                                @if ($product->status == 3)
                                                    <div class="d-flex justify-content-end">

                                                        <a target="__blank" class="btn custom-button d-lg-none mt-2"
                                                            href="{{ $product->website }}">{{ __('words.visit_here') }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    @if (!$is_invite)
                        <button class="event-buttton" type="submit">
                            <span>{{ __('words.confirmed') }}</span>
                            <span id="totalPrice" x-ref="total"
                                x-text="'{{ Sohoj::price(Cart::session($event->slug)->getTotal()) }}'"> <i
                                    class="fa fa-arrow-right"></i></span>
                        </button>
                    @else
                        <button data-bs-toggle="modal" data-bs-target="#inviteCheckoutModal" class="event-buttton"
                            type="button">
                            <span>{{ __('words.invite_confirmed') }}</span>
                            <span id="totalPrice"> <i class="fa fa-arrow-right"></i></span>
                        </button>
                    @endif

                </div>

            </div>
        </div>
    </section>
    @if ($is_invite)
        <div class="modal fade" id="inviteCheckoutModal" tabindex="-1" aria-labelledby="inviteCheckoutModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inviteCheckoutModalLabel">{{ __('words.your_information') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="security" value="{{ request()->security }}">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input name="name" type="text" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input name="email" type="email" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('words.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('words.claim') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </form>
@endsection
@section('js')
    <script defer src="{{ asset('assets/js/alpine.js') }}"></script>
    <script>
        function eventData() {
            return {
                tickets: {},
                quantities: {},
                updateTicket(id, price) {
                    this.tickets[id] = price * this.quantities[id];
                    this.calculateTotal();
                },
                calculateTotal() {
                    let total = Object.values(this.tickets).reduce((sum, value) => sum + value, 0);
                    this.$refs.total.innerText = 'Є' + total.toFixed(2);
                }
            };
        }
    </script>
@endsection
