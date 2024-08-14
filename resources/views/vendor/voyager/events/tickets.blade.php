@extends('voyager::master')
@section('page_title', $event->title . 'Orders')
@section('css')
    <style>
        .pill {
            border-radius: 8px;
            padding: 4px 10px;
        }

        .pill-success {
            color: rgb(5, 202, 38);
            background-color: rgba(172, 255, 47, 0.325);
        }

        .pill-secondary {
            color: rgb(59, 59, 59);
            background-color: rgba(27, 27, 27, 0.325);
        }

        .pill-danger {
            color: rgb(160, 0, 0);
            background-color: rgba(251, 1, 1, 0.325);
        }

        .pill-warning {
            color: rgb(160, 56, 0);
            background-color: rgba(160, 56, 0, 0.343);
        }

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
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <form method="get">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" placeholder="Search orders"
                                    value="{{ request('search') }}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('voyager.events.customer.analytics.tickets', ['event' => $event, 'user' => $user]) }}"
                                    class="btn btn-danger">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-3">
                        <div class="card ">
                            <h3 class="">
                                Total Ticket
                            </h3>
                            <h1 class="">
                                {{ $event->tickets->count() }}
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <h3>
                                Total Sold
                            </h3>
                            <h1>
                                {{ Sohoj::price($event->tickets()->sum('price')) }}
                            </h1>
                        </div>
                    </div>
                    @foreach ($ticketsByStatus as $status => $count)
                        <div class="col-md-3">
                            <div class="card ">
                                <h3>
                                    {{ $status }}
                                </h3>
                                <h1>
                                    {{ $count }}
                                </h1>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="table-responsive">

                    <table class="table table-hover">
                        <thead>
                            <tr class="text-center">
                                <th>Id</th>
                                <th>Ticket</th>
                                <th style="width: 120px;">Status</th>
                                <th>Price</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>
                                    Logs
                                </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->ticket }}</td>
                                    <td> <span
                                            class="pill pill-{{ $ticket->getBsStatusClass() }}">{{ $ticket->status() }}</span>
                                    </td>
                                    <td>{{ Sohoj::price($ticket->price) }}</td>
                                    <td>{{ $ticket->created_at->format(' d F, Y') }}</td>
                                    <td>{{ $ticket->updated_at->format(' d F, Y') }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($ticket->logs as $log)
                                                <li>
                                                    {{ $log['action'] . ' at ' . Carbon\Carbon::parse($log['time'])->format('d M H:i') . ' from ' . $log['zone'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="align-center" style="display: flex">
                                        <a style="margin:5px;"
                                            href="{{ route('download.ticket', ['order' => $ticket->order, 't' => $ticket->ticket]) }}"
                                            class="btn btn-sm btn-info pull-right">
                                            <i class="voyager-download"></i> Download
                                        </a>

                                        <a href="{{ route('send.email', ['order' => $ticket->order, 'product' => $ticket->product_id, 'ticket' => $ticket->id]) }}"
                                            class="btn btn-sm btn-warning pull-right">
                                            <i class="voyager-mail"></i> Send Mail
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="text-center">
                    {{ $tickets->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        <!-- Filter and Search Form -->


    </div>




@endsection
