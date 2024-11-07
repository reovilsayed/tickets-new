@extends('voyager::master')

@section('page_title', $event->title . ' analytics')

@section('css')
    <style>
        .card {
            text-align: center;
            padding: 20px;
            width: 100%;
            border-radius: 10px;

            border: 2px solid #EF5927 !important;
            transition: .2s ease-in;
        }

        .card:hover {
            box-shadow: 5px 5px #EF5927;
        }

        .card h3 {
            text-transform: uppercase;
            font-weight: bold;
            margin: 0px;
            font-size: 30px;
            color: #EF5927;
            font-family: Arial, Helvetica, sans-serif;
        }

        .card h1 {
            font-size: 50px;
            font-weight: bold;
            color: #000;
        }

        h1 {
            font-size: 40px;
            font-weight: bold;
            color: #000;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1>
            {{ $event->name }} - Analytics
        </h1>

        <hr>
        @include('vendor.voyager.events.partial.buttons')
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Digital Sales',
                        'value' => $event->digitalTickets->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Physical Tickets',
                        'value' => $event->physicalTickets->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Pos SAles',
                        'value' => 000,
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Invites Send',
                        'value' => $event->inviteTickets->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Total',
                        'value' => $event->tickets->count(),
                    ])
                </div>

                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Tickets',
                        'value' => $event->products->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Invites',
                        'value' => $event->invites->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Customer',
                        'value' => $event->tickets()->distinct('user_id')->pluck('user_id')->count(),
                    ])

                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Product',
                        'value' => $event->extras->count(),
                    ])

                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Digital Sales Money',
                        // 'value' => Sohoj::price($event->tickets()->sum('price') / 100),
                        'value' => 0,
                    ])

                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Pos Sales Money',
                        // 'value' => Sohoj::price($event->tickets()->sum('price') / 100),
                        'value' => 0,
                    ])

                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Total Sales Money',
                        'value' => Sohoj::price($event->tickets()->sum('price') / 100),
                    ])

                </div>
            </div>
        </div>
    </div>
@endsection
