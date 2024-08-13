@extends('voyager::master')
@section('page_title', $event->title . 'Orders')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card" style="margin-top: 10px">
                <div class="card-body">
                    <!-- Filter and Search Form -->
                    <form method="GET" class="form-search">
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
                                    <th>Order Id</th>
                                    <th>Status</th>
                                    <th>Discount</th>
                                    <th>Total</th>
                                    <th>Tax</th>
                                    <th>Refund Amount</th>
                                    <th>Date Paid</th>
                                    <th>Date Completed</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td scope="row">{{ $order->id }}</td>
                                        <td>{{ $order->getStatus() }}</td>
                                        <td>{{ Sohoj::price($order->discount) }}</td>
                                        <td>{{ Sohoj::price($order->total) }}</td>
                                        <td>{{ Sohoj::price($order->tax) }}</td>
                                        <td>{{ Sohoj::price($order->refund_amount) }}</td>
                                        <td>{{ optional($order->date_paid)->format('d F, Y') ?? 'N/A' }}</td>
                                        <td>{{ optional($order->date_completed)->format('d F, Y') ?? 'N/A' }}</td>
                                        <td>{{ $order->created_at->format(' d F, Y') }}</td>
                                        <td>
                                            <a href="{{ route('voyager.orders.show', $order) }}"
                                                class="btn btn-sm btn-warning pull-right">
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
