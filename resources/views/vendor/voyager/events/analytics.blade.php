@extends('voyager::master')

@section('page_title', $event->title . ' analytics')

@section('css')
    <style>
        .card {
            padding: 20px;
            width: 100%;
            border-radius: 10px;
            height: 150px;
            border: 2px solid #000000 !important;
            transition: .2s ease-in;
        }

        .card:hover {
            box-shadow: 5px 5px #000000;
        }

        .card h3 {
            margin: 0px;
            font-size: 30px;
            color: #000;
            font-family: Georgia, 'Times New Roman', Times, serif
        }

        .card h1 {
            text-align: right;
            font-size: 50px;
            color: #000;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h3>
            {{ $event->name }} - Analytics
        </h3>
        <br>
        <br>
        <br>
        <a href="{{ route('voyager.events.ticketParticipanReport.analytics', $event) }}"
            class="btn btn-primary">Participants</a>
        <a href="{{ route('voyager.events.salesReport.analytics', $event) }}" class="btn btn-primary">Financial</a>
        <a href="{{ route('voyager.events.customer.analytics', $event) }}" class="btn btn-primary">Customer</a>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <h3>
                        Product
                    </h3>
                    <h1>
                        {{ $event->products->count() }}
                    </h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h3>
                        Ticket
                    </h3>
                    <h1>
                        {{ $event->tickets->count() }}
                    </h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h3>
                        Customer
                    </h3>
                    <h1>
                        {{ $event->tickets()->distinct('user_id')->pluck('user_id')->count() }}
                    </h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h3>
                        Sold
                    </h3>
                    <h1>
                        {{ Sohoj::price($event->tickets()->sum('price')) }}
                    </h1>
                </div>
            </div>
        </div>
    </div>
@endsection
