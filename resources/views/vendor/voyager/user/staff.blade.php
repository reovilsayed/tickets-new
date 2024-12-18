@extends('voyager::master')
@section('page_title', $user->name . ' Scans')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css"
         />

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

    </style>
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
            font-size: 20px;
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
@endsection
@endsection
@section('content')
    <div class="container">
        <h1>
            Staff Report - {{$user->name.' '.$user->l_name}}
        </h1>
        <div class="panel">
            <div class="panel-body">
                <div class="row">

                    @foreach ($data as $key => $product)
                        <div class="col-md-4">
                            @include('vendor.voyager.events.partial.card', [
                                'label' => $key,
                                'value' => $product,
                            ])
                        </div>
                    @endforeach
                </div>


                <div class="table-responsive">

                    <table class="table table-hover" id="datatable">
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

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $id => $data)
                                @php
                                    $ticket = App\Models\Ticket::where('ticket', $id)->first();
                                @endphp
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
                                            @foreach ($data as $log)
                                                <li>
                                                    {{ $log['log'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="text-center">
                    {{-- {{ $tickets->links('pagination::bootstrap-4') }} --}}
                </div>
            </div>
        </div>
        <!-- Filter and Search Form -->


    </div>




@endsection
@push('javascript')
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
    <script>
        new DataTable('#datatable');
    </script>
@endpush
