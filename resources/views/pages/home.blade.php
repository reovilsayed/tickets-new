@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/star-rating.css') }}" media="all" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        .star {
            font-size: 20px !important;
        }

        .testimonials .item .info i {
            color: #bd3d06;
            font-size: 20px;
        }



        .mobile-card {
            height: 150px;
            width: 100%;
            background-position: center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: end;
            padding-bottom: 10px
        }

        .mobile-cards-sec {
            position: fixed;
            bottom: 0;
            z-index: 99999;
            width: 100%;
            background-color: black;

        }


        @media screen and (min-width:479px) {
            #mobile-cards-sec {
                display: none !important;

            }

        }
    </style>
@endsection

@section('content')
    <section class="mobile-cards-sec scroll-none" id="mobile-cards-sec" style="background-color: black">
        <div class="d-flex justify-content-between">
            @foreach ($featureOffers->take(3) as $mobileItem)
                <div class="" style="width: 32%">
                    <div class="mobile-card" style="background-image:url({{ Voyager::image($mobileItem->image) }})"
                        onclick="window.location.href = '{{ $mobileItem->path() }}';">


                        <a href="{{ $mobileItem->path() }}" class="px-2 py-1 text-white "
                            style="background-color: #bd3d06;font-size:12px">
                            <span
                                title="{{ $mobileItem->name }}">{{ Illuminate\Support\Str::limit($mobileItem->name, 10) }}</span>
                        </a>


                    </div>
                </div>
            @endforeach

        </div>
    </section>

    <section class="rooms1 section-padding bg-cream" data-scroll-index="1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle">{{ __('Get Events') }}</div>
                    {{-- <div class="section-title">{{ __('words.feature_sec_subtittle') }}</div> --}}
                </div>
            </div>
            <div class="row">
                @foreach ($featureOffers as $product)
                    <div class="col-md-4">
                        <x-products.product :product=$product />
                    </div>
                @endforeach

            </div>
        </div>
    </section>



    {{-- <section class="facilties section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle">{{ __('words.facilities_sec_subtittle') }}</div>
                    <div class="section-title">{{ __('words.facilities_sec_tittle') }}</div>
                </div>
            </div>
            <div class="row">
                @foreach ($facilities as $facility)
                    <div class="col-md-4">
                        <div class="single-facility animate-box" data-animate-effect="fadeInUp">

                            <h5>{{ $facility->name }}</h5>
                            <p>{{ $facility->description }}</p>
                            <div class="facility-shape"> <span class="flaticon-world"></span> </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section> --}}
@endsection
@section('js')
    <script src="{{ asset('assets/js/star-rating.js') }}" type="text/javascript"></script>
    <script>
        $("#product_rating").rating({
            showCaption: true
        });
        $(".published_rating").rating({
            showCaption: false,
            readonly: true,
        });
        window.addEventListener('scroll', function() {
            var scrollY = window.scrollY;
            var scrollingElement = document.getElementById('mobile-cards-sec');
            if (scrollY) {
                scrollingElement.classList.remove('mobile-cards-sec');


            } else {
                scrollingElement.classList.add('mobile-cards-sec');
            }
        });
    </script>
@endsection
