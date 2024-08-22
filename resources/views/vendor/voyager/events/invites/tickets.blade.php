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
        h1{
            font-size: 40px;
            font-weight: bold;
            color: #000; 
        }
    </style>
      <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endsection
@section('javascript')
<script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    <script>
        var table = $('#dataTable').DataTable()
    </script>
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
            <div class="panel">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="card ">
                                <h3 class="">
                                    Total Ticket
                                </h3>
                                <h1 class="">
                                    {{ $tickets->count() }}
                                </h1>
                            </div>
                        </div>
                       
                        @foreach ($ticketsByStatus as $status => $count)
                            <div class="col-md-6">
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

                        <table class="table table-hover" id="dataTable">
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
                                            <a href="{{ route('voyager.ticket.extras', ['ticket' => $ticket]) }}"
                                                class="btn btn-sm btn-primary pull-right edit">
                                                <i class="voyager-plus"></i> Add Product
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                   
                </div>
            </div>
            <!-- Filter and Search Form -->


        </div>
    </div>





@endsection
