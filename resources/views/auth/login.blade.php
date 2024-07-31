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
    <div class="container login-wrapper">
        <div class="col-md-5 mb-20 offset-md-1 p-5">
            <form method="post" class="" action="{{ route('login') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12 form-group">
                        <input class="login-input" id="email" type="email" placeholder="{{ __('Email') }}"
                            class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                            required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 form-group">
                        <input class="login-pass" id="password" type="password" placeholder="Password"
                            class="@error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <a href="{{ route('password.request') }}" class="" style="color: #ffffff">I Forgot
                            Password</a>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="login-btn text-white"> Login </button>
                    </div>
                    <div class="col-md-12">

                        <span class="">Don't Have an account ? <a class="text-warning" href="{{ route('register') }}">
                                Register</a></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
@endsection
