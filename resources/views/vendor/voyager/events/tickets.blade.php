@extends('voyager::master')
@section('page_title', $event->title . 'Orders')

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
                                    <th>Ticket Id</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Dates</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td scope="row">{{ $ticket->id }}</td>
                                        <td>{{ $ticket->status() }}</td>
                                        <td>{{ Sohoj::price($ticket->price) }}</td>
                                        <td>{{ optional($ticket->dates)->format('d F, Y') ?? 'N/A' }}</td>
                                        <td>{{ $ticket->created_at->format(' d F, Y') }}</td>
                                        <td class="align-center">
                                            <a href="" class="btn btn-sm btn-warning pull-right">
                                                <i class="voyager-eye"></i> View
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
