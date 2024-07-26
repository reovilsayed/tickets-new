<div class="row" style="">
    <div class="col-lg-4 ps-0 d-flex mid-bn mb-4 me-5 margin-left"
        style="height: 275px; overflow:hidden;position:relative">
        <div class="col-6 p-4 ms-4">
            <p style="font-size:14px">{{ setting('offer.offer1category') }}</p>
            <h4>{{ setting('offer.offer1Title') }}</h4>
            <a class="mid-btn mt-4 btn btn-dark" href="{{ setting('offer.offer1link') }}"><span
                    style="font-size: 10px">View Collection</span></a>
        </div>
        <div class="col-6">
            <div class="add-thumbnail-1"
                style="    height: 200px;
            width: 200px;
            position: absolute;
            top: 28px;
            right: 6px;">
                <img style="; height:100%" src="{{ Voyager::image(setting('offer.offer1Image')) }}" alt="">
            </div>
        </div>
    </div>
    <div class="col-lg-7 mid-bn mb-4" style="overflow: hidden">
        <div class="row">
            <div class="col-md-4 p-4 ms-4">
                <p>{{ setting('offer.offer2category') }}</p>
                <h4>{{ setting('offer.offer2Title') }}</h4>
                <a class="mid-btn mt-4 btn btn-dark" href="{{ setting('offer.offer2link') }}"><span
                        style="font-size: 10px">View Collection</span></a>
            </div>
            <div class="col-6">
                <div class="add-img-thumbnail" style="height: 206px;">
                    <img style="height: 100%; width: 100%;object-fit: contain;"
                        src="{{ Voyager::image(setting('offer.offer2Image')) }}" alt="">
                </div>

            </div>
        </div>
    </div>
</div>
