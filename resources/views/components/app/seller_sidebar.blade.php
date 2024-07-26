<div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
    <div class="ec-sidebar-wrap ec-border-box">
        <!-- Sidebar Category Block -->
        <div class="ec-sidebar-block">
            <div class="ec-vendor-block " style="position:relative">
                @if (auth()->user()->shop)
                <img src="{{ auth()->user()->shop->banner ? Voyager::image(auth()->user()->shop->banner) : asset('assets/img/1.jpg') }}" alt="" style="    height: 190px;
                                    width: 100%;
                                    object-fit: cover;">
                <a href="javascript:void(0)" class="shadow-lg" style="position: absolute; top:-11px; right:-11px; background-color: #fff; border-radius:50%;padding:10px 0" data-bs-toggle="modal" data-bs-target="#coverModal"><span class="mx-3"><i class="fi-rr-edit" style="font-size: 16px;"></i></span></a>
                @else
                <img src="{{ asset('assets/img/1.jpg') }}" alt="" style="height: 190px;
                                width: 100%;
                                object-fit: cover;">
                @endif

                <div class="ec-vendor-block-detail" style="background-color: snow; position:relative">
                    @if (auth()->user()->shop)
                    <div style="position: relative;">
                        <img class="v-img" src="{{ auth()->user()->shop->logo ? Voyager::image(auth()->user()->shop->logo) : asset('assets/img/heaer.jpg') }}" style="object-fit: cover;" alt="vendor image">


                        <a href="javascript:void(0)" class="shadow-lg" style="position: absolute; top:-70px; right:9px; background-color: #fff; border-radius:50%;padding:10px 0" data-bs-toggle="modal" data-bs-target="#logoModal"><span class="mx-3"><i class="fi-rr-edit" style="font-size: 16px;"></i></span></a>
                    </div>
                    <!-- <a href="javascript::void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal"></a>><i class="fi-rr-edit"></i></a> -->
                    @else
                    <div style="position: relative;">
                        <img class="v-img" src="{{ asset('assets/img/heaer.jpg') }}" style="object-fit: cover;" alt="vendor image">
                        <a href="javascript:void(0)" class="shadow-lg" style="position: absolute; top:-70px; right:9px; background-color: #fff; border-radius:50%;padding:10px 0" data-bs-toggle="modal" data-bs-target="#logoModal"><span class="mx-3"><i class="fi-rr-edit" style="font-size: 16px;"></i></span></a>
                    </div>
                    @endif
                    <h5>{{ auth()->user()->name }}</h5>
                    <p>( {{ auth()->user()->shop ? auth()->user()->shop->name : 'no shop has been created' }} )</p>
                </div>
                <div class="ec-vendor-block-items">
                    <ul>
                        <li><a href="{{ route('vendor.dashboard') }}">Dashboard</a></li>
                        @if (Auth()->user()->shop)
                        @if (Auth()->user()->shop->status == 1)
                        <li><a href="{{ route('vendor.ordersIndex') }}">Orders</a></li>
                        <li><a href="{{ route('vendor.products') }}">Products</a></li>
                        @endif
                        @endif
                        <li><a href="{{ route('vendor.shop') }}">Shop Profile</a></li>
                        <li><a href="{{ route('vendor.settings') }}">Settings (Edit)</a></li>
                        <li><a href="{{ route('vendor.ticket.index') }}">Support</a></li>
             
                        {{-- <li><a href="{{ route('vendor.massage') }}">Massages</a></li> --}}
                   
                       
                        {{-- <li><a href="{{ route('vendor.charges') }}">Subscription</a></li> --}}
                        {{-- <li><a href="{{ route('vendor.banner') }}">Offer Banner</a></li> --}}
                        {{-- <li><a href="{{ route('vendor.offers') }}">Offer Request</a></li> --}}
                        {{-- <li><a href="{{ route('vendor.shopPolicy') }}">Shop Policy</a></li> --}}
                   

                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Send Logo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('vendor.logo.cover') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="email">Logo</label>
                        <input type="file" class="" required name="logo" id="logo" aria-describedby="emailHelp">
                    </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="butn-dark2 "><span>Save changes</span></button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="coverModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Send Cover Photo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('vendor.logo.cover') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="email">Cover</label>
                        <input type="file" class="" required name="banner" id="banner" aria-describedby="emailHelp" >
                    </div>




            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="butn-dark2 "><span>Save changes</span></button>
            </div>
            </form>
        </div>
    </div>
</div>