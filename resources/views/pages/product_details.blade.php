@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/star-rating.css') }}" media="all" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        .star {
            font-size: 20px;
        }

     @media screen and (min-width:1200px){
        #card-info.fixed {
            position: fixed;
            top: 195px;
            right: 185px;
            z-index: 9;
            width: 285px;
        }
     }
    </style>
@endsection
@section('content')
    @php
        $images = json_decode($product->images) ?? [];

    @endphp

  
   
    <section class="rooms-page section-padding" data-scroll-index="1">
        <div class="container">
           
            <div class="row">
                <div class="col-md-12">
               
                    @foreach ($product->prodcats as $item)
                        <div class="section-subtitle">{{ $item->name }}</div>
                    @endforeach
                    <div class="section-title">{{ $product->name }}</div>
                </div>
                <div class="col-md-8">
                    {!! $product->description !!}

                </div>
                <div class="col-md-3 offset-md-1" id="card-info">
                   
                    @php

                        use Carbon\Carbon;
                        $expiredDate = $product->expired_at;
                        $today = Carbon::today();
                    @endphp
                    <div class="mb-3" style="background-color: #F5F5F5">
                        <div class="px-3 py-2">
                            <h4 class="text-center" style="font-size:25px">{{ __('words.expired_at') }}
                                <p>{{ $product->expired_at->format('d-M-Y') }}
                                    @if ($expiredDate > $today)
                                        ( {{ $today->diffInDays($expiredDate) }} {{ __('words.days_left') }})
                                    @elseif($expiredDate->isToday())
                                        ({{ __('words.days_left') }})
                                    @else
                                        ({{ __('words.already_expired') }})
                                    @endif
                                    
                                </p>
                            </h4>
                            <div class="d-flex justify-content-between">

                                <span class="">{{ __('words.price') }}</span>
                                @if ($product->sale_price)
                                    <span class=""> {{ Sohoj::price($product->sale_price) }} </span>
                                @else
                                    <span class=""> {{ Sohoj::price($product->price) }} </span>
                                @endif
                            </div>


                            <div class="">
                                <form action="{{ route('cart.store') }}" method="post">
                                    @csrf
                                    <input type="hidden" class="form-control qty" value="1" min="1"
                                        name="quantity">
                                    <input type="hidden" name="product_id"value="{{ $product->id }}" />

                                    <button class="butn-dark2 mt-15 w-100"><span> {{ __('Add To Cart') }}</span></button>

                                </form>
                            </div>


                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </section>
    @php
        $user = Auth()->id();
        $rating = App\Models\Rating::where('user_id', $user)
            ->where('product_id', $product->id)
            ->get();

    @endphp
  
   
    
    
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
            var scrollingElement = document.getElementById('card-info');
            var scrollY = window.scrollY;

            if (scrollY >= 600 && scrollY <= 1500) { // Change 100 to your desired scroll position
                scrollingElement.classList.add('fixed');
            } else {
                scrollingElement.classList.remove('fixed');
            }
        });
    </script>
@endsection
