@extends('layouts.app')
@section('title', $magazine->name)
@section('meta_description', 'magazine meta data')
@section('keywords', 'meta keyword')
@section('css')
    <style>
        .terms ul li {
            list-style: disc;
        }

        .t-des u {
            text-decoration: underline !important;
        }

        .t-des ul {
            list-style-type: disc !important;
            list-style-position: inside !important;
            padding-left: 20px !important;
            margin: 0 0 1rem 0;
        }

        .t-des ol {
            list-style-type: decimal !important;
            list-style-position: inside !important;
            padding-left: 20px !important;
            margin: 0 0 1rem 0;
        }

        .t-des li {
            display: list-item !important;
            list-style: disc !important;
        }

        @media only screen and (max-width: 480px) {
            .navbar {
                margin-top: 50px;
            }

            #pills-tab {
                position: fixed;
                top: 0px;
                width: 100%;
                z-index: 999;
            }

            #pills-tabContent {
                height: 100% !important;
            }

            .event-buttton {
                position: fixed;
                bottom: 0;
                background-color: #28BADF !important;
                z-index: 999;
            }
        }

        .event-buttton {
            background-color: #28BADF !important;
            /* Dark navbar */
        }

        .card-ticket {
            background-color: #ffffff !important;
            /* Light gray */
            border: 1px solid #ffffff !important;
            /* Add border */
        }

        .sec-hd {
            background-color: #28BADF !important;
        }

        .days {
            color: #000000 !important;
        }

        .sold {
            border: 2px solid #28BADF !important;
            color: #28BADF !important;
        }

        .sold-sm {
            border: 2px solid #28BADF !important;
            color: #28BADF !important;
        }

        .ticket-select {
            border: 2px solid #28BADF !important;
        }

        .nav-pills .nav-link .active {
            color: #0a0402 !important;
        }

        .card-ticket.selected {
            border: 3px solid #28BADF !important;
            background-color: rgba(40, 186, 223, 0.1);
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <form action="{{ route('magazine.cart.store', $magazine->slug) }}" method="post" x-data="magazineCart">
        @csrf
        <section class="rooms1 section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 event-details d-none d-md-block">

                        <img class="d-none d-md-block ms-4" src="{{ Voyager::image($magazine->image) }}" alt=""
                            style="width: 88%; height:auto;">

                        <h2 class="events-title mt-2 px-3 text-center">{{ $magazine->name }}</h2>
                        <div class="accordin-item">
                            <div class="ms-2">
                                <i class="fa fa-info-circle fa-2x" style="color: #28BADF;"></i>
                            </div>
                            <div class="me-3">
                                <h5>{{ __('words.description') }}</h5>
                                <p>{!! $magazine->description !!}</p>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-8 event-box" id="mobile-device">
                        <ul class="nav nav-pills sec-hd mb-3 sticky-sm-top" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-onetime-purchase" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false"
                                    @click="resetInactiveTabSelections('onetime')">
                                    <div class="days">
                                        One-time Subscription
                                        <span class="dot"></span>
                                    </div>
                                </button>
                            </li>

                            @foreach ($subscriptionNames as $sub)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" data-bs-toggle="pill"
                                        data-bs-target="#pills-{{ Str::slug($sub->name) }}-purchase" type="button"
                                        role="tab" aria-controls="pills-profile" aria-selected="false"
                                        @click="resetInactiveTabSelections('{{ Str::slug($sub->name) }}')">
                                        <div class="days">
                                            {{ ucfirst($sub->name) }} Subscription
                                            <span class="dot"></span>
                                        </div>
                                    </button>
                                </li>
                            @endforeach

                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-onetime-purchase" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                @foreach ($archives as $archive)
                                    <div class="card card-ticket active">
                                        <div class="card-body tick">
                                            @if ($archive->quantity <= 0)
                                                <span class="text-danger sold-sm">{{ __('words.sold') }}</span>
                                            @endif
                                            <div class="ticket-info">
                                                <div class="t-info">
                                                    <p class="t-title">{{ $archive->title }}</p>
                                                    <p class="t-des"> {!! $archive->description !!}</p>
                                                </div>
                                                <div class="t-prize">
                                                    <span
                                                        class="text-dark me-2 ticket-prize">{{ Sohoj::price($archive->price) }}</span>
                                                </div>
                                                @if ($archive->quantity > 0)
                                                    <select name="archive[{{ $archive->id }}]" min="0"
                                                        max="3" class="ticket-select"
                                                        style="border: 2px solid #28BADF !important"
                                                        x-model="selectedItems.onetime[{{ $archive->id }}]"
                                                        @change="calculateTotal">
                                                        @for ($i = 0; $i <= $archive->quantity; $i++)
                                                            <option value="{{ $i }}">{{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="pills-annual-purchase" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                @foreach ($annualSubscriptions as $subscription)
                                    <div class="card card-ticket cursor-pointer"
                                        @click="selectSubscription('annual', {{ $subscription->id }})"
                                        :class="{ 'selected': selectedItems.annual === {{ $subscription->id }} }">
                                        <div class="card-body tick">
                                            <div class="ticket-info">
                                                <div class="t-info">
                                                    <p class="t-title">{{ ucfirst($subscription->subscription_type) }}
                                                        Subscription</p>
                                                    <div class="t-des" style="color: #041c47 !important;">
                                                        {!! $subscription->description !!}
                                                    </div>
                                                </div>
                                                <div class="t-prize">
                                                    <h4>{{ Sohoj::price($subscription->price) }}</h4>
                                                </div>
                                                <input type="hidden" name="subscription[annual]"
                                                    x-model="selectedItems.annual">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane fade" id="pills-bi-annual-purchase" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                @foreach ($biAnnualSubscriptions as $subscription)
                                    <div class="card card-ticket cursor-pointer"
                                        @click="selectSubscription('biannual', {{ $subscription->id }})"
                                        :class="{ 'selected': selectedItems.biannual === {{ $subscription->id }} }">
                                        <div class="card-body tick">
                                            <div class="ticket-info">
                                                <div class="t-info">
                                                    <p class="t-title">{{ ucfirst($subscription->subscription_type) }}
                                                        Subscription</p>
                                                    <div class="t-des" style="color: #041c47 !important;">
                                                        {!! $subscription->description !!}
                                                    </div>
                                                </div>
                                                <div class="t-prize">
                                                    <h4>{{ Sohoj::price($subscription->price) }}</h4>
                                                </div>
                                                <input type="hidden" name="subscription[biannual]"
                                                    x-model="selectedItems.biannual">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button class="event-buttton">
                            <span>{{ __('words.invite_confirmed') }}</span>
                            <span id="totalPrice">
                                <span x-text="'Є' + totalPrice.toFixed(2)"></span>
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <button class="btn btn-primary rounded-circle btn-sm p-2 d-md-none d-block"
            style="position:fixed;bottom:120px;left:30px;z-index:2" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <i class="fa fa-info-circle fa-2x"></i>
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="event_img d-none d-md-block">
                    <img src="{{ Voyager::image($magazine->image) }}" alt="">
                </div>

                <h2 class="events-title mt-2 px-3 text-center">{{ $magazine->name }}</h2>
                <div class="text-center d-md-none">
                    <a href="#mobile-device"><button
                            class="custom-button back-button">{{ __('words.envent_list') }}</button></a>
                </div>
                <div class="accordins">
                    <div class="accordin-item">
                        <div>
                            <i class="fa fa-location-pin fa-2x"></i>
                        </div>
                        <div>
                            <h5>Location</h5>
                        </div>
                    </div>
                    <div class="accordin-item">
                        <div>
                            <i class="fa fa-info-circle fa-2x"></i>
                        </div>
                        <div>
                            <div class="accordion-item">
                                <h5 id="event-terms-heading" role="button" data-bs-toggle="collapse"
                                    data-bs-target="#description_event" aria-expanded="true"
                                    aria-controls="description_event">
                                    {{ __('words.description') }}
                                </h5>
                                <div id="description_event" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        {!! $magazine->description !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordin-item">
                        <div>
                            <i class="fa-solid fa-file-contract fa-2x"></i>
                        </div>
                        <div>
                            <div class="accordion-item">
                                <h5 id="event-terms-heading" role="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('words.terms') }}
                                </h5>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Magazine terms
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script defer src="{{ asset('assets/js/alpine.js') }}"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('magazineCart', () => ({
                selectedItems: {
                    onetime: {},
                    annual: null,
                    biannual: null
                },
                prices: {
                    onetime: {!! json_encode($archives->pluck('price', 'id')) !!},
                    annual: {!! json_encode($annualSubscriptions->pluck('price', 'id')) !!},
                    biannual: {!! json_encode($biAnnualSubscriptions->pluck('price', 'id')) !!}
                },
                totalPrice: 0,

                init() {
                    // Initialize all quantities to 0
                    Object.keys(this.prices.onetime).forEach(id => {
                        this.selectedItems.onetime[id] = 0;
                    });

                    this.calculateTotal();
                },

                calculateTotal() {
                    this.totalPrice = 0;

                    // Calculate for one-time purchases
                    Object.keys(this.selectedItems.onetime).forEach(id => {
                        const quantity = parseInt(this.selectedItems.onetime[id]) || 0;
                        this.totalPrice += quantity * (this.prices.onetime[id] || 0);
                    });

                    // Calculate for annual subscription if selected
                    if (this.selectedItems.annual) {
                        this.totalPrice += parseFloat(this.prices.annual[this.selectedItems.annual] ||
                            0);
                    }

                    // Calculate for bi-annual subscription if selected
                    if (this.selectedItems.biannual) {
                        this.totalPrice += parseFloat(this.prices.biannual[this.selectedItems
                            .biannual] || 0);
                    }
                },

                selectSubscription(type, id) {
                    // Reset other type if switching between annual/bi-annual
                    if (type === 'annual') {
                        this.selectedItems.biannual = null;
                    } else if (type === 'biannual') {
                        this.selectedItems.annual = null;
                    }

                    // Toggle selection
                    if (this.selectedItems[type] === id) {
                        this.selectedItems[type] = null; // Deselect if same item clicked
                    } else {
                        this.selectedItems[type] = id; // Select new item
                    }

                    this.calculateTotal();
                },

                resetInactiveTabSelections(activeTab) {
                    // Reset quantities for inactive tabs
                    if (activeTab !== 'onetime') {
                        Object.keys(this.selectedItems.onetime).forEach(id => {
                            this.selectedItems.onetime[id] = 0;
                        });
                    }

                    if (activeTab !== 'annual') {
                        this.selectedItems.annual = null;
                    }

                    if (activeTab !== 'biannual') {
                        this.selectedItems.biannual = null;
                    }

                    this.calculateTotal();
                }
            }));
        });
    </script>
@endsection
