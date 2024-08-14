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

                            <div>
                                <input type="text" name="search" class="form-control" placeholder="Search orders"
                                    value="{{ request('search') }}">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ route('voyager.events.customer.analytics.orders', ['event' => $event, 'user' => $user]) }}"
                                        class="btn btn-danger">
                                        Reset
                                    </a>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
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
                    <div class="col-md-3">
                        <div class="card">
                            <h3>
                                Toatl Sold
                            </h3>
                            <h1>
                                {{ Sohoj::price($event->orders()->sum('total') / 100) }}
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <h3>
                                Total Refund
                            </h3>
                            <h1>
                                {{ Sohoj::price($event->orders()->sum('refund_amount') / 100) }}
                            </h1>
                        </div>
                    </div>
                    @foreach ($ordersByStatus as $status => $count)
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
                                <th>Order Id</th>
                                <th style="width: 120px;">Status</th>
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
                <div class="text-center">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
