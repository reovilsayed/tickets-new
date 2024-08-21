@extends('voyager::master')

@section('page_title', $event->title . ' Customer')
@section('css')
    <style>
        .card {
            padding: 20px;
            width: 100%;
            border-radius: 10px;
            height: 150px;
            border: 2px solid #EF5927 !important;
            transition: .2s ease-in;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card>div:last-child{
            display: flex;
            flex-direction: column;
        }
        .card:hover {
            box-shadow: 5px 5px #EF5927;
        }

        .card h3 {
            margin: 0px;
            font-size: 30px;
            color: #EF5927;
            font-family: Georgia, 'Times New Roman', Times, serif
        }

        .card h1 {
            text-align: right;
            font-size: 50px;
            color: #EF5927;
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
        <h3>
            {{ $event->name }} | Customer Report
        </h3>

        @foreach ($users as $user)
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div>

                            <h3>
                                {{ $user->name . ' ' . $user->l_name }}
                            </h3>
                            <p>
                                {{ $user->email }}
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('voyager.events.customer.analytics.orders', ['event' => $event, 'user' => $user]) }}"
                                class="btn btn-custom">
                                View Orders
                            </a>
                            <a href="{{ route('voyager.events.customer.analytics.tickets', ['event' => $event, 'user' => $user]) }}"
                                class="btn btn-custom">
                                View Tickets
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
    
@endsection
