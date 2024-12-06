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
@php
$productsellamount = 0;
foreach ($extras as $extra) {
    if($extra != null){
        $productsellamount += $extra->qty * $extra->price;
    }
}
@endphp
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
                        'value' => $digitalTickets->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Physical',
                        'value' => $event->physicalTickets->count(),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Pos SAles',
                        'value' => $posTickets->count(),
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
                        'label' => 'Total Sales',
                        'value' => ($digitalTickets->count() + $posTickets->count()),
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
                        'value' => Sohoj::price($digitalOrder->sum('total')),
                    ])

                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Pos Sales Products',
                        // 'value' => Sohoj::price($event->tickets()->sum('price') / 100),
                        'value' => Sohoj::price($posOrder->sum('total') - $posTickets->sum('price') ),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Pos Sales Tickets',
                        // 'value' => Sohoj::price($event->tickets()->sum('price') / 100),
                        'value' => Sohoj::price($posTickets->sum('price')),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Total Pos Sales',
                        // 'value' => Sohoj::price($event->tickets()->sum('price') / 100),
                        'value' => Sohoj::price($posOrder->sum('total')),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Total Sales Money',
                        'value' => Sohoj::price($digitalOrder->sum('total') + $posOrder->sum('total')),
                    ])

                </div>

                {{-- <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Total Product  Sales',
                        'value' => Sohoj::price($totalProductSales),
                    ])
                </div>
                <div class="col-md-4">
                    @include('vendor.voyager.events.partial.card', [
                        'label' => 'Total Ticket Sales',
                        'value' => Sohoj::price($event->tickets->sum('price')),
                    ])
                </div> --}}
            </div>
        </div>
    </div>
@endsection
