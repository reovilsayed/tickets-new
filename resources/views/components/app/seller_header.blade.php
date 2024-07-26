<div class="ec-header-bottom d-lg-block">
    <div class="container position-relative">
        <div class="row">
            <div class="ec-flex flex-wrap">
                <!-- Ec Header Logo Start -->
                <div class="align-self-center">
                    <div class="header-logo">
                        <a href="{{ route('homepage') }}"><img src="{{ Voyager::image(setting('site.logo')) }}"
                                height="100px" style="width:100%" alt="Site Logo" /><img class="dark-logo"
                                src="assets/images/logo/dark-logo.png" alt="Site Logo" style="display: none;" /></a>
                        <!-- <a href="{{ route('homepage') }}"><img src="{{ Voyager::image(setting('site.logo')) }}"
                                alt="{{ setting('site.title') }}"></a> -->
                    </div>
                </div>

                <div class="align-self-center">
                    <div class="d-flex align-items-center">
                        <!-- <div class="ec-select-inner sellers-dropdown mx-2">
                            <select name="ec-select" id="ec-select" style="font-weight: 600;color: black !important">

                                <option value="1">{{ auth()->user()->shop ? auth()->user()->shop->name : 'no shop has been created' }}</option>
                                <option value="2">Pizza Hut-1</option>
                                <option value="2">Pizza Hut-2</option>
                                <option value="2">Pizza Hut-3</option>

                            </select>
                        </div> -->
                        <!-- <a href="#ec-side-cart" class=" ec-side-toggle">
                            <i class="fa-regular fa-folder me-3" style="font-size:20px"></i>
                        </a>
                        <a href="#ec-side-cart " class=" ec-side-toggle">
                            <i class="fa-regular fa-comment me-3" style="font-size:20px"></i>
                        </a> -->
                        <div class="ec-header-user dropdown">
                            @php
                                if (auth()->user()->shop) {
                                    $shop = auth()->user()->shop->id;
                                } else {
                                    $shop = null;
                                }
                                $notifications = App\Models\Notification::where('shop_id', $shop)
                                    ->where('status', 0)
                                    ->latest()
                                    ->get();
                            @endphp


                            <div class="header-top-curr dropdown">
                                <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">
                                    <div>
                                        <i class="fa-regular fa-bell me-3" style="font-size:20px"></i>
                                        @if (auth()->user()->shop)
                                            <span
                                                style="position: absolute;left: 12px;top: -11px;border-radius: 50%;padding: 0px 6px;color: red;">{{ $notifications->count() }}</span>
                                        @else
                                            <span
                                                style="position: absolute;left: 12px;top: -11px;border-radius: 50%;padding: 0px 6px;color: red;">0</span>
                                        @endif
                                    </div>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach ($notifications as $notification)
                                        <li class="active"><a class="dropdown-item"
                                                href="{{ route('massage.seen', $notification) }}">{{ $notification->title }}
                                                <small class="pt-5"
                                                    style="font-weight: 500; font-size:10px;margin:0 10px">({{ $notification->created_at->diffForHumans() }})</small></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>


                        </div>

                        <!-- <a href="wishlist.html" class=" ec-header-wishlist">
                            <i class="fa-solid fa-gear me-3" style="font-size:20px"></i>
                        </a> -->
                        <a href="#" class=" ec-header-wishlist">
                            <img src="{{ auth()->user()->shop ? Voyager::image(auth()->user()->shop->logo) : asset('assets/img/heaer.jpg') }}"
                                height="50" alt="">
                        </a>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
