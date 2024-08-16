@extends('layouts.app')
@section('css')
    <style>
        .enter-zone {
            position: relative;
            height: 150vh;
            background-color: #f36a30;
        }

        .enter-zone .whitebox {
            background-color: rgb(221, 221, 221);
            height: 75vh;
            border-bottom-left-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom-right-radius: 20px;
        }

        .whitebox .logo {
            width: 500px;
        }

        .login-box {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: absolute;
            background-color: #fff;
            width: 50vw;
            top: 50%;
            padding: 50px 20px;
            border-radius: 20px;
            right: 50%;
            transform: translate(50%, -50%)
        }

        .login-box form {
            width: 50%;
        }

        .login-box input {

            background-color: rgb(221, 221, 221) !important;
            padding: 10px 10px !important;
            border-radius: 20px;
            text-align: center;

        }

        .login-box button {
            width: 100%;
            border: none;
            border-radius: 20px;
        }

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

        @media only screen and (max-width: 600px) {
            .enter-zone {
                height: 100vh;
            }

            .enter-zone .whitebox {
                height: 50vh;
            }

            .login-box {
                width: 80vw;
            }

            .login-box form {
                width: 100%;
            }
        }
    </style>
@endsection
@section('content')
    {{-- <section class="ticket-interzone my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5 inter-card" style="height: 15rem;">
                        <div class="card-body">
                            <div class="interzone">
                                <label for=""> {{ __('words.ineter_zone_title1') }}</label>
                                <input type="text" placeholder="{{__('words.enter_your_code')}}" name="">
                                <div class="text-end">
                                    <a href="{{ route('interzone_2') }}" style="font-size:14px">
                                        <button class="custom-button back-button"> {{ __('words.go') }}</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="enter-zone">
        <div class="whitebox">
            <img src="{{ Storage::url(setting('site.logo_black')) }}" class="logo" alt="">
        </div>
        <div class="login-box">
            <form action="{{ route('extraszone.enter.post') }}" method="post">
                @csrf
                <input name="code" type="text" placeholder="Enter Code">
                <button type="submit" class="btn btn-primary">Enter</button>
            </form>
        </div>
    </section>
@endsection
