@extends('layouts.app')
@section('css')
    <style>
        .login-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar .navbar-nav .nav-link {
            color: black;
        }
    </style>
@endsection
@section('content')
    <div class="contaner login-wrapper">
        <div class="col-md-5 mb-20 offset-md-1 p-5"
            style="background-color:#ffff; box-shadow: rgba(15, 15, 15, 0.24) 0px 3px 8px;">
            <h3>{{ __('Register') }}<h3>

                    <form method="post" class="" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input id="name" type="text" placeholder="{{ __('First Name') }}"
                                    class=" @error('name') is-invalid @enderror" name="name" value=""
                                    required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input id="l_name" type="text" placeholder="{{ __('Last Name') }}"
                                    class=" @error('l_name') is-invalid @enderror" name="l_name" value=""
                                    required autocomplete="l_name" autofocus>
                                @error('l_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input id="email" type="email" placeholder="{{ __('Email Address') }}"
                                    class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                                    required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input id="contact_number" type="text" placeholder="{{ __('Contact Number') }}"
                                    class=" @error('contact_number') is-invalid @enderror" name="contact_number" value=""
                                    required autocomplete="contact_number" autofocus>
                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input id="password" type="password" placeholder="{{ __('Password') }}"
                                    class="@error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="col-md-6 form-group">
                                <input id="password-confirm" type="password" placeholder="{{ __('Confirm Password') }}"
                                    class="" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <input type="hidden" name="role_id" value="2" id="">
                            <div class="col-md-6 mt-3">
                                <button type="submit" class="butn-dark2 me-3"><span>Register</span></button>
                            </div>
                            <div class="col-md-6 mt-3">
                                <span style="font-size: 18px">Already have an account ? <a class="text-success"
                                        href="{{ route('login') }}"> login</a></span>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/frontend-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

    <script src="{{ asset('assets/frontend-assets/js/main.js') }}"></script>
@endsection
