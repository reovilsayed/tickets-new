@extends('layouts.app')
@section('content')
    <!-- Header Banner -->
    {{-- <div class="banner-header section-padding valign bg-img bg-fixed" data-overlay-dark="3" data-background="{{asset('')}}">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-left caption mt-90">
                    <h5>{{__('Contact_Hero_Subtittle')}}</h5>
                    <h1>{{__('Contact_Hero_Tittle')}}</h1>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Contact -->
    <section class="contact section-padding">
        <div class="container">
            <div class="row mb-10">
                <div class="col-md-6 mb-10">
                    <h3>{{setting('site.title')}}</h3>
                    <p>{{setting('site.about')}}</p>
                    <div class="reservations mb-30">
                        <div class="icon"><span class="flaticon-call"></span></div>
                        <div class="text">
                            <p class="dashboard-title">{{__('words.contact_reservation')}}</p> <a href="tel:{{setting('site.phone')}}">{{setting('site.phone')}}</a>
                        </div>
                    </div>
                    <div class="reservations mb-30">
                        <div class="icon"><span class="flaticon-envelope"></span></div>
                        <div class="text">
                            <p class="dashboard-title">{{__('words.contact_email_info')}}</p> <a href="mailto:{{setting('site.email')}}">{{setting('site.email')}}</a>
                        </div>
                    </div>
                    <div class="reservations">
                        <div class="icon"><span class="flaticon-location-pin"></span></div>
                        <div class="text">
                            <p class="dashboard-title">{{__('words.contact_address')}}</p>
                            {!! setting('site.address') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-10 offset-md-1">
                    <h3>{{__('words.contact_form')}}</h3>
                    <form method="post" class="" action="{{route('contact.store')}}">
                        @csrf
                        <!-- form message -->
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success contact__msg" style="display: none" role="alert"> {{ __('words.your_message_was_not_sent_successful') }} </div>
                            </div>
                        </div>
                        <!-- form elements -->
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input name="name" class="@error('name') is-invalid @enderror" type="text" placeholder="{{__('words.contact_name')}} *" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="email" class="@error('email') is-invalid @enderror" type="email" placeholder="{{__('words.contact_email')}} *" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="phone" type="text" class="@error('phone') is-invalid @enderror" placeholder="{{__('words.contact_number')}} *" required>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <input name="subject" class="@error('subject') is-invalid @enderror" type="text" placeholder="{{__('words.contact_subject')}}*" required>
                                @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <textarea name="message" class="@error('message') is-invalid @enderror" id="message" cols="30" rows="4" placeholder="{{__('words.contact_message')}} *" required></textarea>
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="butn-dark2"><span>{{__('words.send_message')}}</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
   
@endsection
