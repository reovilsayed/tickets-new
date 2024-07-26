@php
$images = json_decode($product->images) ?? [];

@endphp
<div class="row">
    <div class="col-md-5 col-sm-12 col-xs-12">
        <!-- Swiper -->
        <div class="qty-product-cover">
            <div class="qty-slide">
                <img class="img-responsive" src="{{ Storage::url($product->image) }}" alt="">
            </div>
            @foreach ($images as $image)
                
            <div class="qty-slide">
                <img class="img-responsive" src="{{ Storage::url($image) }}" alt="">
            </div>
            @endforeach
          
        </div>
        <div class="qty-nav-thumb">
            <div class="qty-slide">
                <img class="img-responsive" src="{{ Storage::url($product->image) }}" alt="" >
            </div>
            @foreach ($images as $image)
            <div class="qty-slide">
                <img class="img-responsive" src="{{ Storage::url($image) }}" alt="" >
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-7 col-sm-12 col-xs-12">
        <div class="quickview-pro-content">
            <h5 class="ec-quick-title"><a href="">{{$product->name}}</a>
            </h5>
            <div class="ec-single-rating-wrap">
                <div class="ec-single-rating">
                    <input value="{{ Sohoj::average_rating($product->ratings) }}" class="rating published_rating" data-size="xs">
                </div>

            </div>

            <div class="ec-quickview-desc">{{ $product->short_description }}</div>
            <div class="ec-quickview-price">
                @if($product->sale_price)
                <span class="old-price">{{ Sohoj::price($product->price) }}</span>
                @endif
                <span class="new-price">{{ Sohoj::price($product->sale_price ?? $product->price) }}</span>
            </div>
            <form action="{{ route('cart.store') }}" method="post">
                @csrf
                <div class="ec-quickview-qty">

                    <input type="hidden" class="" name="product_id" value="{{ $product->id }}" />
                    <div class="qty-plus-minus">
                        <input class="qty-input" type="text" name="quantity" value="1" />
                    </div>
                    <div class="ec-quickview-cart ">
                        <button type="submit" class="btn btn-primary"><i class="fi-rr-shopping-basket"></i> Add To Cart</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/star-rating.js') }}"></script>
<script>
    $("#product_rating").rating({
        showCaption: true
    });
    $(".published_rating").rating({
        showCaption: false,
        readonly: true,
    });
</script>

<script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/slick.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>