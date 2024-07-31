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
        <div class="col-md-5 mb-20 offset-md-1 p-5">
            <h3 class="text-center">{{ __('Register') }}<h3>
                    <form method="post" class="" action="{{ route('register') }}">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input id="name" type="text" placeholder="{{ __('First Name') }}"
                                    class="reg-pass @error('name') is-invalid @enderror" name="name" value=""
                                    required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input id="l_name" type="text" placeholder="{{ __('Last Name') }}"
                                    class="reg-pass @error('l_name') is-invalid @enderror" name="l_name" value=""
                                    required autocomplete="l_name" autofocus>
                                @error('l_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input id="email" type="email" placeholder="{{ __('Email Address') }}"
                                    class="reg-pass @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input id="contact_number" type="text" placeholder="{{ __('Contact Number') }}"
                                    class="reg-pass @error('contact_number') is-invalid @enderror" name="contact_number"
                                    value="" required autocomplete="contact_number" autofocus>
                                @error('contact_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input id="password" type="password" placeholder="{{ __('Password') }}"
                                    class="reg-pass @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                            <div class="col-md-6 form-group">
                                <input id="password-confirm" type="password" placeholder="Confirm Password" class="reg-pass"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <input type="hidden" name="role_id" value="2" id="">
                            <div class="col-md-12">
                                <button type="submit" class="reg-btn text-white" style="font-size: 22px">Register</button>
                            </div>

                            <div class="col-md-12">
                                <span style="font-size: 18px">Already have an account ? <a class="text-warning"
                                        href="{{ route('login') }}"> login</a></span>
                            </div>
                        </div>
                    </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('assets/frontend-old-assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/frontend-old-assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>

    <script src="{{ asset('assets/frontend-old-assets/js/main.js') }}"></script>
@endsection
