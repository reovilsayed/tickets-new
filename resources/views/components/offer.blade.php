<div class="row" style="">
@if($shop->category1)
    <div class="col-lg-4 ps-0 d-flex mid-bn mb-4 me-5 margin-left"
        style="height: 275px; overflow:hidden;position:relative">
      
        <div class="col-6 p-4 ms-4">
           
            <p style="font-size:14px">{{ $shop->category1 ? $shop->category1 : 'Please Category Add'  }}</p>
            <h4>{{ $shop->title1 ? $shop->title1 : 'Please Add title' }}</h4>
            <a class="mid-btn mt-4 btn btn-dark" href="{{ $shop->link1 }}"><span
                    style="font-size: 10px">View Collection</span></a>
        </div>

     
        <div class="col-6">
            <div class="add-thumbnail-1" style="height:268px; width:252px;">
                <img style="height:100%"
                    src="{{ $shop->image1 ? Storage::url($shop->image1) : asset('assets/img/store_front/bnwatch.png') }}" alt="">
            </div>
        </div>
    
    </div>
    @endif
    @if($shop->category2)
    <div class="col-lg-7 mid-bn mb-4" style="overflow: hidden">
        <div class="row">
      
            <div class="col-md-4 p-4 ms-4">
                <p>{{ $shop->category2 ? $shop->category2 : 'Please Add Category' }}</p>
                <h4>{{ $shop->title2 ? $shop->title2 : "Please add Title" }}</h4>
                <a class="mid-btn mt-4 btn btn-dark" href="{{ $shop->link2 }}"><span
                        style="font-size: 10px">View
                        Collection</span></a>
            </div>
         
            <div class="col-6">
                <div class="add-img-thumbnail" style="height: 206px;margin-top:10px">
                    <img style="height: 100%; width: 100%;object-fit:contain" src="{{ $shop->image2 ? Storage::url($shop->image2) : asset('assets/img/store_front/bnbag.png') }}"
                        alt="">
                </div>

            </div>

        </div>
    </div>
    @endif
</div>
