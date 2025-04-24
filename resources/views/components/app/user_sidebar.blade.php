<div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
    <div class="ec-sidebar-wrap ec-border-box">
        <!-- Sidebar Category Block -->
        <div class="ec-sidebar-block">
            <div class="ec-vendor-block">

                <div class="ec-vendor-block-items">
                    <ul class="sidebar-dashboard">
                        <li class="{{ Route::is('user.dashboard') ? 'active-class' : '' }}"><a
                                href="{{ route('user.dashboard') }}"><i class="fa-solid fa-house fa-1x"></i>
                                {{ __('words.dashboard') }}</a></li>
                        <li class=" {{ Route::is('user.ordersIndex') ? 'active-class' : '' }}"><a
                                href="{{ route('user.ordersIndex') }}"><i class="fa-solid fa-chart-simple fa-1x"></i>
                                {{ __('words.orders') }}</a></li>
                        <li class=" {{ Route::is('user.magazineIndex') ? 'active-class' : '' }}"><a
                                href="{{ route('user.magazineIndex') }}"><i class="fa-solid fa-chart-simple fa-1x"></i>
                                {{ __('words.magazines') }}</a></li>


                        <li class="{{ Route::is('user.change_password') ? 'active-class' : '' }}"><a
                                href="{{ route('user.change_password') }}"><i class="fa-solid fa-key"></i>
                                {{ __('words.security') }}</a>
                        </li>
                        <li class="">
                            <form action="{{ route('logout') }}" id="logoutform" method="post"
                                style="display: inline-block">
                                @csrf

                            </form>
                            <button onclick="document.getElementById('logoutform').submit()" type="submit"
                                class="user-log"><i class="fa-solid fa-user"></i>
                                {{ __('words.logout') }}</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
