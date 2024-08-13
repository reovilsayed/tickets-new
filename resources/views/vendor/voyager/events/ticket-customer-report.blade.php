@extends('voyager::master')

@section('page_title', $event->title . ' Customer')
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
            {{ $event->name }} | Customer Report
        </h3>

        @foreach ($users as $user)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h3>
                            {{ $user->name . ' ' . $user->l_name }}
                        </h3>
                        <p>
                            {{ $user->email }}
                        </p>
                        <a href="{{route('voyager.events.customer.analytics.orders',['event'=>$event,'user'=>$user])}}" class="btn btn-dark">
                            View Orders
                        </a>
                        <a href="{{route('voyager.events.customer.analytics.tickets',['event'=>$event,'user'=>$user])}}" class="btn btn-dark">
                            View Tickets
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
