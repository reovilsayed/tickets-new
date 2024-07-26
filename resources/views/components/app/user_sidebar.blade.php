<div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
    <div class="ec-sidebar-wrap ec-border-box">
        <!-- Sidebar Category Block -->
        <div class="ec-sidebar-block">
            <div class="ec-vendor-block">
                {{-- <div class="ec-vendor-block-bg"></div> --}}
                <div class="ec-vendor-block-detail">
                    <img class="v-img" style="object-fit: cover" src="{{ Storage::url(auth()->user()->avatar) }}"
                        alt="User image">
                    <h5>{{ auth()->user()->name }} {{ auth()->user()->l_name }} </h5>
                </div>
                <div class="ec-vendor-block-items">
                    <ul>



                        <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>



                        <li><a href="{{ route('user.ordersIndex') }}">Orders</a></li>
                        <li><a href="{{ route('user.update_profile') }}">Edit
                                Profile</a> </li>
                        {{-- <li><a href="{{ route('user.offers') }}">Offers</a> </li>
                        <li><a href="{{ route('massage.create') }}">Massages</a> </li> --}}

                        <li><a href="{{ route('user.change_password') }}">Change Password</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="text-muted">logout</button>
                            </form>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
