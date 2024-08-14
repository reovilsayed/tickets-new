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
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="card" style="margin-top: 10px">
                <div class="card-body">
                    <!-- Filter and Search Form -->
                    <form method="GET" class="">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" name="search" class="form-control" placeholder="Search orders"
                                    value="{{ request('search') }}">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>

                    </form>

                    <div class="table-responsive">

                        <table class="table table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>Ticket</th>
                                    <th>Status</th>
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
                                        <td class="align-center">
                                            <a href="{{ route('download.ticket', ['order' => $ticket->order, 't' => $ticket->ticket]) }}"
                                                class="btn btn-sm btn-info pull-right">
                                                <i class="voyager-download"></i> Download
                                            </a>

                                            <a href="{{ route('send.email', ['order' => $ticket->order, 'product' => $ticket->product_id, 'ticket' => $ticket->id]) }}"
                                                class="btn btn-sm btn-warning pull-right">
                                                <i class="voyager-mail"></i> Send Email
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Pagination Links -->
                        {{-- <div class="d-flex justify-content-center">
                    {{ $orders->appends(request()->query())->links() }}
                </div> --}}
                    </div>
                </div>
            </div>




        </div>
    </div>
@endsection
