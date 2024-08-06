@extends('layouts.app')
@section('content')
    {{-- <x-app.header /> --}}
    {{-- <h3 class="text-center my-5 py-5">
    Thank you for registering!
    Please confirm your email! <br>
    <a href="{{route('again.verify.token')}}" class="btn btn-dark me-auto mt-4">Resend email</a>
</h3> --}}

    <div class="banner-header section-padding valign bg-img bg-fixed" data-overlay-dark="4"
        data-background="{{ asset('assets/frontend-assets/img/slider/1.jpg') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 caption mt-90 p-5"
                    style="box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;background-color:#bd3d06">
                    <h3> {{ __('words.thank_you_for_registering') }}!
                        {{ __('words.please_confirm_your_email') }}! <br>
                    </h3>
                    <a href="{{ route('again.verify.token') }}" class="btn btn-dark me-auto mt-4"
                        style="background-color: #bd3d06">{{ __('words.resend_email') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
