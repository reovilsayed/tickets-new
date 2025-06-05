@extends('voyager::master')
@section('page_title', $event->title . 'Pos Report')
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
            widtd: 100%;
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

        .search-group {
            align-items: center;
            display: grid;
            grid-template-columns: 8fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }

        .search-group input,
        .form-control {
            padding: 0px 20px;
            height: 40px;
            border-radius: 20px;
            outline: none;
            box-shadow: none;
            border: 1px solid #EF5927;
            color: #000;
            font-weight: bold;
        }

        .search-group button {
            height: 40px;
            border-radius: 20px;
        }
    </style>
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endsection
@section('javascript')
    <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    <script>
        var table = $('#dataTable').DataTable()
    </script>
    <script>
        document.querySelectorAll('.ticket-resolve-button').forEach(button => {
            button.addEventListener('click', function() {
                const url = this.getAttribute('data-url');

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload(); // Refresh to show updated status
                        }
                    });
            });
        });
    </script>
@endsection
@section('content')
    <div class="container">
        <h1>{{ $event->name }} - Analytics</h1>
        <hr>
        @include('vendor.voyager.events.partial.buttons')
        <hr>
        <form action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input name="search" type="text" class="form-control" placeholder="Search Here">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select name="alert" class="form-control">
                            <option value="">All</option>
                            <option @if (request()->alert == 'marked') selected @endif value="marked">Marked</option>
                            <option @if (request()->alert == 'unmarked') selected @endif value="unmarked">Not Marked</option>
                            <option @if (request()->alert == 'resolved') selected @endif value="resolved">Resolved</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input value="{{ request()->date }}" name="date" type="date" id="date"
                            class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="staff" id="staff" class="form-control">
                            <option value="">Select Staff</option>
                            @foreach ($staffs as $staff)
                                <option value="{{ $staff->id }}" @selected($staff->id == request('staff'))>{{ $staff->fullName() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="search-group">
                        <button class="btn btn-custom"><i class="voyager-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="{{ request()->fullUrlWithQuery(['export' => 'summary']) }}" class="btn btn-success">
                        <i class="voyager-download"></i> Export Summary
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['export' => 'products']) }}" class="btn btn-warning">
                        <i class="voyager-download"></i> Export Products
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['export' => 'orders']) }}" class="btn btn-primary">
                        <i class="voyager-download"></i> Export Orders
                    </a>
                </div>
            </div>
        </form>
        <div class="panel">
            <div class="panel-body">
                <div class="row">
                    @php
                        $totalAmount = $order_total?->cash_amount + $order_total?->card_amount - $markedAmount;
                    @endphp
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Total Amount',
                            'value' => Sohoj::price($totalAmount),
                        ])
                    </div>

                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Marked Amount',
                            'value' => Sohoj::price($markedAmount),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Card Amount',
                            'value' => Sohoj::price($order_total?->card_amount),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Cash Amount',
                            'value' => Sohoj::price($order_total?->cash_amount),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Total Ticket Sell',
                            'value' => $tickets->sum('total') ?? 0,
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Total Product sell',
                            'value' => $order->extra_qty ?? 0,
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Product sell Amount',
                            'value' => Sohoj::price($order?->extra_total),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Ticket sell Amount',
                            'value' => Sohoj::price($order?->total - $order?->extra_total),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Total Paid Invite Amount',
                            'value' => Sohoj::price($totalPaidInvite->sum('price')),
                        ])
                    </div>
                    <div class="col-md-4">
                        @include('vendor.voyager.events.partial.card', [
                            'label' => 'Total Paid Invite ',
                            'value' => $totalPaidInvite->count(),
                        ])
                    </div>




                </div>

                <h1 class="p-3">
                    {{ __('words.tickets') }}
                </h1>
                <div class="row">
                    @foreach ($tickets as $ticket)
                        <div class="col-md-4">

                            @include('vendor.voyager.events.partial.card', [
                                'label' => $ticket->product?->name,
                                'value' => $ticket->total,
                            ])

                        </div>
                    @endforeach
                </div>
                <h1 class="p-3">
                    {{ __('words.extras') }}
                </h1>
                <div class="row">
                    @foreach ($extras as $extra)
                        <div class="col-md-4">
                            @include('vendor.voyager.events.partial.card', [
                                'label' => $extra->name,
                                'value' => $extra->qty,
                            ])
                        </div>
                    @endforeach
                </div>
                <h1 class="p-3">
                    {{ __('words.withdraw_logs') }}
                </h1>

                <div class="row">

                    @foreach ($withdrawCounts as $entry)
                        <div class="col-md-4">
                            @include('vendor.voyager.events.partial.card', [
                                'label' => 'Withdraws of: ' . $entry->name,
                                'value' => $entry->total, // <-- change this from withdraw_count to total
                            ])
                        </div>
                    @endforeach

                </div>
                <table class="table table-hover">
                    <thead>
                        <tr class="">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Description</th>
                            <th>Invoice</th>
                            <th>Note</th>
                            <th>Alert</th>
                        </tr>
                    </thead>
                    <tbody id="ticket-table-body">
                        @foreach ($allOrders as $allOrder)
                            <tr>
                                <td>
                                    {{ $allOrder->id }}
                                </td>
                                <td>{{ $allOrder->user->name }}</td>
                                <td>{{ $allOrder->billing->email ?? $allOrder->user->email }}</td>
                                <td>{{ $allOrder->billing->phone ?? $allOrder->user->contact_number }}</td>
                                <td>
                                    <ul>
                                        @foreach ($allOrder->getDescription() as $line)
                                            <li>
                                                {{ $line }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    @if (!empty($allOrder->invoice_url) && !empty($allOrder->invoice_id))
                                        <a href="{{ $allOrder->invoice_url }}">Invoice
                                            #{{ $allOrder->invoice_id }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $allOrder->note }}</td>
                                <td>
                                    @if ($allOrder->alert == 'unmarked')
                                        <button type="button" class="btn btn-primary ticket-marked-button"
                                            data-url="{{ route('order.marked', ['order' => $allOrder]) }}"
                                            data-bs-toggle="modal" data-bs-target="#ticket-marked">
                                            Mark
                                        </button>
                                    @elseif($allOrder->alert == 'resolved')
                                        <button class="btn btn-success">Resolved</button>
                                    @elseif($allOrder->alert == 'marked')
                                        <button class="btn btn-danger">Marked</button>
                                    @endif
                                    <span class="d-none" id="ticket-action-url-{{ $allOrder->id }}"
                                        data-email-url="{{ route('order.email', $allOrder) }}"
                                        data-sms-url="{{ route('order.sms', $allOrder) }}"></span>

                                </td>
                                <td style="display: none">{{ $allOrder->alert }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $allOrders->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="ticket-marked">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tell us why you marked this?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" id="ticket-marked-form">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Note:</label>
                            <textarea class="form-control" rows="10" name="note" id="message-text"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="action-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tell us why you marked this?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container">
                    <form action="#" id="ticket-action-form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="johndoe@example.com">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="phone number">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="send-sms-ticket" class="btn btn-danger">Send SMS</button>
                    <button id="email-ticket" class="btn btn-success">Send Email</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
