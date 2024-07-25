<header class="header-section">
    <div class="container">
        <div class="header-wrapper">
            <div class="logo">
                <a href="{{ route('index') }}">
                    <img src="assets/images/logo/logo.png" alt="logo">
                </a>
            </div>
            <ul class="menu">
                <li>
                    <a href="{{ route('index') }}" class="">events</a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('index') }}" class="active">Events</a>
                        </li>
                        <li>
                            <a href="{{ route('event_details') }}">Event Details</a>
                        </li>
                        <li>
                            <a href="{{ route('event_speaker') }}">Event Speaker</a>
                        </li>
                        <li>
                            <a href="{{ route('event_tickets') }}">Event Ticket</a>
                        </li>
                        <li>
                            <a href="{{ route('event_checkout') }}">Event Checkout</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('about') }}">About Us</a>

                </li>

                <li>
                    <a href="{{ route('contact') }}">Contact us</a>
                </li>
                <li class="header-button pr-0">
                    <a href="{{ route('login') }}">join us</a>
                </li>
                <li>
                    @if (Auth::check())
                        {{ Auth::user()->name }}
                    @endif
                    <ul class="submenu">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="header-bar d-lg-none">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>
