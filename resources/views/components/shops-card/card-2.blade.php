    <div class="col-lg-3 mb-6  pro-gl-content-shop">
        <div class="ec-product-inner position-relative shop-cards">
            <div class="ec-pro-actions shop-end position-absolute" style="right: 0px;">


                <a class="ec-btn-group wishlist-shop"
                    style="z-index: 9;justify-content: center;display: flex;align-items: center;"><i
                        class="fa-solid fa-heart" style="color: #ffffff;"></i></a>
            </div>
            <div class="ec-pro-image-outer ">
                <div class="ec-pro-image " style="border:none">
                    <a href="{{ route('store_front', $shop->slug) }}" class="image">
                        <img class="main-image" src="{{ Storage::url($shop->logo) }}" style="object-fit: cover;"
                            alt="Product" />
                        <img class="hover-image" src="{{ Storage::url($shop->logo) }}" alt="Product"
                            style="object-fit: cover;" />
                    </a>


                </div>
            </div>
            <div class="ec-pro-content text-center" style=" background-color: inherit">
                <h5 class="ec-pro-title ec-pro-title-shop"><a style="font-size: 14px"
                        href="{{ route('store_front', $shop->slug) }}">{{ $shop->name }}</a>
                </h5>
                <div class="ec-pro-list-desc">
                    <p style="font-size: 9px">
                        {{ Str::limit($shop->short_description, $limit = 30, $end = '...') }}
                    </p>
                </div>
                <div class="d-flex justify-content-center btn-group-sm" style="margin-right: 5px" role="group"
                    aria-label="Basic example">
                    @if ($shop->tags == !null)
                        @php
                            $tags = explode(',', $shop->tags);
                        @endphp
                        @foreach ($tags as $tag)
                            <span class="btn-light py-1 px-2 me-2"
                                style="font-size: 10px;color: #787885;height: 25px;">{{ Str::limit($tag, $limit = 5, $end = '...') }}</span>
                        @endforeach
                    @endif
                </div>

                <div class="ec-pro-rating d-flex justify-content-center" style="margin-top:13px">
                    <input value="{{ Sohoj::average_rating($shop->ratings) }}" class="rating published_rating"
                        data-size="sm">
                    <span>({{ $shop->ratings->count() }})</span>
                </div>



            </div>
        </div>
    </div>
