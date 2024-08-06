@extends('layouts.app')
@section('css')
    <style>
        /* svg{
                                    height: 200px;
                                } */
        .navbar .navbar-nav .nav-link {
            color: black;
        }

        .section-space-p {
            margin-top: 70px;
        }

        .eci-check-circle {
            font-size: 50px;
            text-align: center;
            color: #1EBA62;
        }

        .ec-title {
            font-size: 40px;
            text-transform: uppercase;
        }
    </style>
@endsection

@section('content')
    <section class="ec-thank-you-page section-space-p my-5">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="ec-thank-you section-space-p">
                        <!-- thank content Start -->

                        <div>
                            <img src="/assets/thankyou.png" alt="">
                        </div>


                        <h2 class="thank-title text-center">{{ __('words.so_much_for_purchasing_a_Ticket') }} . </h2>
                        {{-- <p class="sub-title">For Shopping with us.</p> --}}
                        <div class="d-flex justify-content-center">
                            <i class="thank-i fa fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
