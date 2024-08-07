<nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- Logo -->
        <div class="logo-wrapper">
            <a class="logo" href="{{ route('homepage') }}"> <img src="{{ Voyager::image(setting('site.logo')) }}" 
               class="logo-img" alt="{{ setting('site.title') }}"> </a>

            <!-- <a class="logo" href="index.html"> <h2>THE CAPPA <span>Luxury Hotel</span></h2> </a> -->
        </div>
        <!-- Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
            aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation"> <span
                class="navbar-toggler-icon"><i class="fa fa-bars fa-2x text-white"></i></span></button>
        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown"> <a
                        class="nav-link dropdown-toggle {{ Route::is('homepage') ? 'active' : '' }}"
                        href="{{ route('homepage') }}">{{ __('words.home') }}</a>
                </li>
                {{-- <li class="nav-item dropdown"> <a
                        class="nav-link dropdown-toggle {{ Route::is('shops') ? 'active' : '' }}"
                        href="{{ route('shops') }}">{{ __('Events') }} </a>
                </li>
                <li class="nav-item"><a class="nav-link {{ Route::is('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">{{ __('About Us') }}</a></li> --}}
                {{-- <li class="nav-item"><a class="nav-link {{ Route::is('posts') ? 'active' : '' }}"
                        href="{{ route('posts') }}">{{ __('words.news') }}</a></li> --}}
                {{-- <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">Rooms & Suites <i class="ti-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="rooms.html" class="dropdown-item"><span>Rooms 1</span></a></li>
                        <li><a href="rooms2.html" class="dropdown-item"><span>Rooms 2</span></a></li>
                        <li><a href="rooms3.html" class="dropdown-item"><span>Rooms 3</span></a></li>
                        <li><a href="room-details.html" class="dropdown-item"><span>Room Details</span></a></li>
                    </ul>
                </li> --}}
                {{-- <li class="nav-item"><a class="nav-link" href="restaurant.html">Restaurant</a></li>
                <li class="nav-item"><a class="nav-link" href="spa-wellness.html">Spa</a></li>
                <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">Pages <i class="ti-angle-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="services.html" class="dropdown-item"><span>Services</span></a></li>
                        <li><a href="facilities.html" class="dropdown-item"><span>Facilities</span></a></li>
                        <li><a href="gallery.html" class="dropdown-item"><span>Gallery</span></a></li>
                        <li><a href="team.html" class="dropdown-item"><span>Team</span></a></li>
                        <li><a href="pricing.html" class="dropdown-item"><span>Pricing</span></a></li>
                        <li><a href="careers.html" class="dropdown-item"><span>Careers</span></a></li>
                        <li><a href="faq.html" class="dropdown-item"><span>F.A.Qs</span></a></li>
                        <li class="dropdown-submenu dropdown"> <a class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" href="#"><span>Other Pages <i class="ti-angle-right"></i></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="404.html" class="dropdown-item"><span>404 Page</span></a></li>
                                <li><a href="coming-soon.html" class="dropdown-item"><span>Coming Soon</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li> --}}
                {{-- <li class="nav-item"><a class="nav-link {{ Route::is('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">{{ __('contact_us') }}</a></li> --}}

                @if (auth()->check())
                    <li class="nav-item dropdown"> <a
                            class="nav-link dropdown-toggle @if (request()->segment(1) == 'user') active @endif"
                            href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-expanded="false">{{ __('words.account') }}</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('user.dashboard') }}"
                                    class="dropdown-item {{ Route::is('user.dashboard') ? 'active' : '' }}"><span>{{ __('words.user_dashboard') }}</span></a>
                            </li>
                            {{-- @if (auth()->user()->role_id == 3)
                                <li><a href="{{ route('vendor.dashboard') }}" class="dropdown-item"><span>Vendor
                                            Dashboard</span></a>
                                </li>
                            @endif --}}
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button href="{{ route('user.dashboard') }}"
                                        class="dropdown-item"><span>{{ __('words.logout') }}</span></button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="{{ route('login') }}"
                            role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            {{ __('words.login') }}</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('login') }}"
                                    class="dropdown-item"><span>{{ __('words.login') }}</span></a>
                            </li>
                            <li><a href="{{ route('register') }}"
                                    class="dropdown-item"><span>{{ __('words.register') }}</span></a>
                            </li>

                        </ul>
                    </li>
                @endif
                <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        {{ app()->getLocale() }} <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url()->current() }}?locale=en"
                                class="dropdown-item"><span>{{ __('words.en') }}</span></a>
                        </li>
                        <li><a href="{{ url()->current() }}?locale=pt"
                                class="dropdown-item"><span>{{ __('words.pt') }}</span></a>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
