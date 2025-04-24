@extends('layouts.app')
@section('title', $magazine->title)
@section('meta_description', $magazine->meta_description)
@section('keywords', $magazine->keywords)
@section('css')
    <style>
        .coupon-form div {
            display: grid;
            grid-template-columns: 4fr 1fr;
        }

        .coupon-form input {
            width: 100%;
            height: 40px;
            padding: 10px;
            border: 1px solid #28BADF;
        }

        .coupon-form button {
            box-shadow: 0px 0px #6ba7b680;
            height: 40px;
            border: 1px solid #28BADF;
            border-left: none;
            transition: 1s cubic-bezier(0.075, 0.82, 0.165, 1);
        }

        .coupon-form button:hover {
            background-color: #6eb0c085;
            box-shadow: 5px 5px #28BADF;
        }



        .event-box {
            height: 700px;
            overflow: scroll;
            background-color: #fff !important;
        }

        .accordion-button:not(.collapsed) {
            background-color: #28BADF;
        }

        .accordion-button {
            color: #fff !important;
            font-weight: 600;
            padding: 10px 20px;
            background-color: #28BADF;
        }

        .accordion-body {
            border: none;
        }

        .dashboard-title {
            color: #28BADF !important;
        }

        .price-summary {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: 600;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total-row {
            font-weight: bold;
            font-size: 1.2rem;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')

    <section class="rooms1 section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-4 event-details d-none d-md-block">
                    <img class="d-none d-md-block ms-4" src="{{ Voyager::image($magazine->image) }}" alt=""
                        style="width: 88%; height:auto;">

                    <h2 class="events-title mt-2 px-3 text-center">{{ $magazine->name }}</h2>
                    <div class="accordin-item">
                        <div class="ms-2">
                            <i class="fa fa-info-circle fa-2x" style="color: #28BADF;"></i>
                        </div>
                        <div class="me-3">
                            <h5>{{ __('words.description') }}</h5>
                            <p>{!! $magazine->description !!}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 event-box">
                    <div class="row m-0">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0" style="color: #28BADF !important">{{ __('words.hello,') }}
                                        {{ auth()->user()->name }}</h3>
                                    <p>{{ auth()->user()->contact_number }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    {{ $js }}
@endsection
