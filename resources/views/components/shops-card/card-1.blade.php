<div class="col-12 mb-6  pro-gl-content-shop shadow-sm shop-cards">
    <div class="ec-product-inner position-relative pt-3">
        <!-- @auth
        <form id="followForm" action="{{ route('follow', $shop) }}" method="post">
            <div class="ec-pro-actions shop-end position-absolute" style="right: 0px; top:-10px">
                @csrf
                @php
                $follow = auth()
                ->user()
                ->follows($shop);
                @endphp
                @if(auth()->user()->isFollowingShop($shop->id))
                <button type="button" data-shop-id="{{ $shop->id }}" style="cursor:pointer; z-index: 9;justify-content: center;display: flex;align-items: center; color:rgba(252, 79, 79, 0.96); background-color:#C5C5C5;padding:10px 10px;border-radius:50%" class="wishlist-shop-btn"><i id="shop_heart_{{$shop->id}}" class="fas fa-heart "></i> </button>
                @else

                <button type="button" data-shop-id="{{ $shop->id }}" style="cursor:pointer; z-index: 9;justify-content: center;display: flex;align-items: center; background-color:#C5C5C5;padding:10px 10px;border-radius:50%" class="wishlist-shop-btn"><i id="shop_heart_{{$shop->id}}" class="far fa-heart text-white"></i></button>
                @endif
            </div>
        </form>
        @endauth -->

        <!-- <a href="#" class="ec-btn-group wishlist-shop"
                style="z-index: 9;justify-content: center;display: flex;align-items: center;"><i class="fa-solid fa-heart"
                    style="color: #ffffff;"></i></a> -->

        <div class="ec-pro-image-outer ">
            <div class="ec-pro-image " style="border:none">
                <a href="{{ route('store_front', $shop->slug) }}" class="image">
                    <img class="main-image" src="{{ Storage::url($shop->logo) }}" style="object-fit: cover;" alt="Product" />
                    <img class="hover-image" src="{{ Storage::url($shop->logo) }}" style="object-fit: cover;" alt="Product" />
                </a>


            </div>
        </div>
        <div class="ec-pro-content text-center" style=" background-color: inherit">
            <h5 class="ec-pro-title ec-pro-title-shop"><a style="font-size: 15px" href="{{ route('store_front', $shop->slug) }}">{{ $shop->name }}</a></h5>
            <div class="ec-pro-list-desc">
                <p style="font-size: 13px">{{ Str::limit($shop->short_description, $limit = 30, $end = '...') }}</p>
            </div>
            <div class="d-flex flex-wrap justify-content-center btn-group-sm" style="margin-right: 5px" role="group" aria-label="Basic example">
                @if ($shop->tags == !null)
                @php
                $tags = explode(',', $shop->tags);
                @endphp
                @foreach ($tags as $tag)
                <span class="btn-light py-1 px-2 me-2" style="font-size: 12px;color: #787885;height: 25px;">{{ Str::limit($tag, $limit = 7, $end = '...') }}</span>
                @endforeach
                @endif



            </div>

            <div class="ec-pro-rating d-flex justify-content-center align-items-center" style="margin-top:13px">
                <input value="{{ Sohoj::average_rating($shop->ratings) }}" class="rating published_rating" data-size="sm">
                <span style="font-size: 13px;">({{ $shop->ratings->count() }})</span>
            </div>



        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.wishlist-shop-btn').on('click', function() {
            var button = $(this);
            var shopId = button.data('shop-id');
            var form = button.closest('form');

            $.ajax({
                url: 'follow/' + shopId,
                type: 'Post',
                data: {
                    _token: '{{ csrf_token() }}',

                },
                success: function(response) {

                    var element = $('#shop_heart_' + shopId);
                    if (element.hasClass('far fa-heart')) {
                        element.removeClass('far fa-heart text-white').addClass('fas fa-heart');
                        button.css({'color':'rgba(252, 79, 79, 0.96)'})
                    } else {
                        element.removeClass('fas fa-heart').addClass('far fa-heart text-white');
                    }



                },
                error: function(xhr, status, error) {
                    // Request error, handle the error here
                    console.error(error);
                }
            });
        });
    });
</script>