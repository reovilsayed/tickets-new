@extends('layouts.app')
<style>
    .interzone {
        margin: 50px;
    }

    .interzone>label {
        font-size: 26px;
        color: rgb(255, 255, 255) !important;
    }

    .inter-card {
        background: #001232 !important;
        border: #fff !important;
    }

    .interzone>input::placeholder {
        color: aliceblue !important
    }

    .interzone>input:focus {
        color: aliceblue !important;
    }

    .inter-btn {
        color: white;
        background-color: #4750fd !important;
        border: 2px solid #ffffff;
        padding: 5px 10px;
        border-radius: 10px;
    }
</style>
@section('content')
    <section class="ticket-interzone my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5 inter-card" style="height: 15rem;">
                        <div class="card-body">
                            <div class="interzone">
                                <label for=""> {{ __('words.ineter_zone_title2') }}</label>
                                <input type="text" placeholder="{{__('words.enter_your_code')}}" name="">
                                <div class="text-end">
                                    <a href="{{ route('interzone_1') }}" style="font-size:14px">
                                        <button class="inter-btn mb-4"> {{ __('words.go') }}</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
