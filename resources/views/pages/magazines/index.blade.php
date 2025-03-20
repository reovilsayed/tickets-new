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

    .con {
      position: unset !important;
      background-color: #0a1e5e !important;
      color: #fff !important;
    }

    .rooms1 .item .con h6,
    .rooms1 .item .con h6 a {
      color: white;
    }

    .thumb {
      height: 250px;
    }

    .thumb img {
      height: 100%;
    }

    .rooms1 .item .con h5,
    .rooms1 .item .con h5 a {
      color: #fff;
    }

    .rooms1 .item:hover .line {
      background-color: #bd3d06;
    }

    .rooms1 .item .con .permalink a {
      color: #bd3d06;
    }

    .rooms1 .item .con i {
      color: #bd3d06;
    }

    .category {
      /* border-radius:20px; */
      right: 0px !important;
    }

    .product-title {
      font-size: 17px;
    }
  </style>
@endsection

@section('content')
  <section class="rooms1 section-padding bg-cream" data-scroll-index="1">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-subtitle">{{ __('words.magazine_title') }}</div>
          {{-- <div class="section-title">{{ __('words.feature_sec_subtittle') }}</div> --}}
        </div>
      </div>
      <div class="row">
        @foreach ($magazines as $magazine)
          <div class="col-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
            <div class="item" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
              <a href="{{ $magazine->path() }}" class="d-block">
                <img src="{{ Storage::url($magazine->image) }}" alt="" style="">
              </a>
              <div class="con">
                <h6>$100</h6>

                <h5 style="height: 85px" class="product-title">
                  <a href="{{ $magazine->path() }}" title="{{ $magazine->name }}" class="w-100">{{ Str::limit($magazine->name, 30) }}</a>
                </h5>
                <div class="line"></div>
                <div class=" facilities">
                  <a class="custom-button back-button" href="{{ $magazine->path() }}">{{ __('words.book_ticket') }}</a>
                </div>
              </div>
            </div>
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
