@php
    use Carbon\Carbon;
    $expiredDate = $product->expired_at;
    $today = Carbon::today();

@endphp
<style>
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
</style>
<div class="item" style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;">
    <a href="{{ $product->path() }}" class="thumb d-block">
        <img src="{{ Voyager::image($product->image) }}" alt="" style="">
    </a>
    {{-- <span class="category">
        {{ $product->event_start_date->format('d M') }}
    </span> --}}
    <div class="con">
        <h6><a href="{{ $product->path() }}">
                @if ($product->sale_price)
                    <del>{{ Sohoj::price($product->price) }} </del>
                    {{ Sohoj::price($product->sale_price) }}
                @else
                    {{ Sohoj::price($product->price) }}
                @endif
                <br>
                @foreach ($product->prodcats as $item)
                    /{{ $item->name }}
                @endforeach


            </a></h6>
        <h5 style="height: 85px"><a href="{{ $product->path() }}" class="w-100">{{ $product->name }}</a> </h5>
       @if($product->event_start_date->format('d M') == $product->event_end_date->format('d M'))
       <h6>{{ $product->event_start_date->format('d M')}} </h6>
       @else
       <h6>{{ $product->event_start_date->format('d M')}} - {{ $product->event_end_date->format('d M')}} </h6>
       @endif
        <div class="line"></div>
        <div class=" facilities">
            <a class="custom-button back-button" href="{{ $product->path() }}">{{ __('Book Ticket') }}</a>
        </div>
    </div>
</div>
