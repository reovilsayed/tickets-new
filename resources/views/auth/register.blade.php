@extends('layouts.app')

@section('content')
    <section class="account-section bg_img" data-background="assets/images/account/account-bg.jpg">
        <div class="container">
            <div class="padding-top padding-bottom">
                <div class="account-area">
                    <div class="section-header-3">
                        <span class="cate">welcome</span>
                        <h2 class="title">to Tickets </h2>
                    </div>
                    <form class="account-form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name<span>*</span></label>
                            <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email1">Email<span>*</span></label>
                            <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pass1">Password<span>*</span></label>
                            <input id="password" type="password" class=" @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pass2">Confirm Password<span>*</span></label>
                            <input id="password-confirm" type="password"name="password_confirmation" required
                                autocomplete="new-password">
                        </div>
                        <div class="form-group checkgroup">
                            <input type="checkbox" id="bal" required checked>
                            <label for="bal">I agree to the <a href="#0">Terms, Privacy Policy</a> and <a
                                    href="#0">Fees</a></label>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="Sign Up">
                        </div>
                    </form>
                    <div class="option">
                        Already have an account? <a href="sign-in.html">Login</a>
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
