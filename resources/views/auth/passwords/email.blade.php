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

    <section class="ec-page-content section-space-p">
        <div class="container login-wrapper">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">

                        <h2 class="ec-title">Reset Password</h2>

                    </div>
                </div>
                <div class="ec-login-wrapper">
                    <div class="ec-login-container" style="border: none">
                        <div class="ec-login-form">
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                   

                                    <input id="email" type="email" placeholder="{{ __('Email Address') }}"
                                        class=" @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                    

                                <span class="ec-login-wrap ec-login-btn">
                                    <div class="col-md-12 ">
                                        <button type="submit" class="butn-dark2" style="font-size:14px">
                                          <span>     Send Password reset link</span>
                                        </button>

                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
