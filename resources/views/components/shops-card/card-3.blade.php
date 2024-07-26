    <div class="col-lg-3 col-6 mb-6  pro-gl-content-shop">
        <div class="ec-product-inner position-relative shop-card">
            <div class="ec-pro-actions shop-end position-absolute" style="right: 0px;">


                {{-- <a class="ec-btn-group wishlist-shop"
                    style="z-index: 9;justify-content: center;display: flex;align-items: center;"><i
                        class="fa-solid fa-heart" style="color: #ffffff;"></i></a> --}}
            </div>
            <div class="ec-pro-image-outer p-2" style="background-color: #f5f5f5;">
                <div class="ec-pro-image " style="border:none">
                    <a href="{{ route('store_front', $shop->slug) }}" class="image">
                        <img class="main-image" src="{{ Storage::url($shop->logo) }}" style="object-fit: cover;"
                            alt="Product" />
                        <img class="hover-image" src="{{ Storage::url($shop->logo) }}" alt="Product"
                            style="object-fit: cover;" />
                    </a>


                </div>
            </div>
            <div class="ec-pro-content text-center">
                <h5 class="ec-pro-title ec-pro-title-shop"><a style="font-size: 15px"
                        href="{{ route('store_front', $shop->slug) }}" >{{ $shop->name }}</a>
                </h5>
                <div class="ec-pro-list-desc">
                    <p style="font-size: 13px;color: #787885">
                        {{ Str::limit($shop->short_description, $limit = 30, $end = '...') }}
                    </p>
                </div>
                <div class="d-flex justify-content-center btn-group-sm" style="margin-right: 5px;" role="group"
                    aria-label="Basic example">
                    @if ($shop->tags == !null)
                        @php
                            $tags = explode(',', $shop->tags);
                        @endphp
                        @foreach ($tags as $tag)
                            <span class="btn-light py-1 px-2 me-2" style="font-size: 11px;color: #787885;height: 25px;"
                                title="{{ $tag }}">{{ Str::limit($tag, $limit = 5, $end = '...') }}</span>
                        @endforeach
                    @endif
                </div>

                <div class="ec-pro-rating d-flex justify-content-center align-items-center" style="margin-top:13px">
                    <input value="{{ Sohoj::average_rating($shop->ratings) }}" class="rating published_rating"
                        data-size="sm">
                    <span style="font-size: 13px;">({{ $shop->ratings->count() }})</span>
                </div>



            </div>
        </div>
    </div>
