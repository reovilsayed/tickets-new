@extends('layouts.app')

@section('content')
    <section class="account-section bg_img" data-background="assets/images/account/account-bg.jpg">
        <div class="container">
            <div class="padding-top padding-bottom">
                <div class="account-area">
                    <div class="section-header-3">
                        <span class="cate">hello</span>
                        <h2 class="title">welcome back</h2>
                    </div>

                    <form class="account-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email2">Email<span>*</span></label>
                            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pass3">Password<span>*</span></label>
                            <input id="password" type="password" class="@error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group checkgroup">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>

                            <label for="remember">
                                {{ __('Remember Me') }}
                            </label>
                            <a href="{{ route('password.request') }}" class="forget-pass">Forget Password</a>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="Log In">

                        </div>
                    </form>
                    <div class="option">
                        Don't have an account? <a href="{{ route('register') }}">sign up now</a>
                    </div>
                    <div class="or"><span>Or</span></div>
                    <ul class="social-icons">
                        <li>
                            <a href="#0">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#0" class="active">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#0">
                                <i class="fab fa-google"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
