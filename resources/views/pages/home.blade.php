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
  

    <section class="rooms1 section-padding bg-cream" data-scroll-index="1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-subtitle">{{ __('Get Events') }}</div>
                    {{-- <div class="section-title">{{ __('words.feature_sec_subtittle') }}</div> --}}
                </div>
            </div>
            <div class="row">
                @foreach ($events as $product)
                    <div class="col-md-4">
                        <x-products.product :product=$product />
                    </div>
                @endforeach

            </div>
        </div>
    </section>

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
