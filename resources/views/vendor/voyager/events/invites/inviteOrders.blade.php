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

        h1 {
            font-size: 40px;
            font-weight: bold;
            color: #000;
        }
    </style>
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endsection
@section('javascript')
    <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                dom: 'Bfrtip', // This line integrates buttons in the DataTable
                buttons: [
                    'excelHtml5',
                   
                ]
            });
        });
    </script>
@endsection
@section('content')
    <div class="container">
        <h1>
            {{ $event->name }} - Analytics
        </h1>

        <hr>

        <div class="container">
            <div class="panel">
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <h3>
                                    Total Orders
                                </h3>
                                <h1>
                                    {{ $orders->count() }}
                                </h1>
                            </div>
                        </div>



                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable">
                            <thead>
                                <tr class="text-center">
                                    <th>Order Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Tickets</th>
                                    <th>Quantity</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td scope="row">{{ $order->id }}</td>
                                        <td>{{ $order?->billing?->name }}</td>
                                        <td>{{ $order?->billing?->email }}</td>
                                        <td>{{ $order?->user?->contact_number }}</td>
                                        <td> 
                                            <ul>
                                                @foreach ($order->tickets as $ticket)
                                                <li>{{$ticket->product->name}}</li>
                                                    
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $order->tickets->count()}}</td>
                                        <td>{{ $order->created_at->format(' d F, Y') }}</td>
                                        <td class="align-center" style="display: flex">

                                            <a style="margin-right: 5px;"href="{{ route('voyager.orders.show', $order) }}"
                                                class="btn btn-sm btn-warning pull-right">
                                                <i class="voyager-eye"></i> View
                                            </a>
                                            <a style="margin-right: 5px;"
                                                href="{{ route('download.ticket', ['order' => $order]) }}"
                                                class="btn btn-sm btn-info pull-left">
                                                <i class="voyager-download"></i> Tickets
                                            </a>

                                            <a href="{{ route('send.email', ['order' => $order]) }}"
                                                class="btn btn-sm btn-warning pull-left">
                                                <i class="voyager-mail"></i> Send Mail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
