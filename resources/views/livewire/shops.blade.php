<div>
    @foreach ($latest_shops as $shop)
    @if ($shop->products->count())
    <div class="row mb-4">
        <div class="col-md-3">
            <x-shops-card.card-1 :shop="$shop" />
        </div>
        <div class="col-md-9">
            <div class="ec-spe-products">
                @foreach ($shop->products->whereNull('parent_id')->chunk(4) as $products)
                <div class="ec-fs-product">
                    <div class="ec-fs-pro-inner">

                        <div class="row">
                            @php
                            $last = $loop->last;
                            $count = $shop->products->count();
                            @endphp
                            @foreach ($products as $product)
                            <x-products.product-4 :product="$product" />



                            @endforeach

                            @if($last && $count >=8)
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 pro-gl-content d-flex align-items-center" style="margin-bottom: 35px;">
                                <a href="{{route('store_front',$shop->slug)}}" class="btn btn-dark">View More</a>
                            </div>
                            @endif


                        </div>

                    </div>
                    <!-- 
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 pro-gl-content d-flex align-items-center" style="margin-bottom: 35px;">
                                <a href="#" class="btn btn-dark">View More</a>
                            </div> -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    @endif
    @endforeach
    @if($more_shops)
    <button wire:click="addMoreShops" class="btn btn-dark  me-auto mx-auto" style="display: block; margin: 0 auto;">View More</button>
    @endif
</div>