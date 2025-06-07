@php
    $productsellamount = 0;
    foreach ($extras as $extra) {
        $productsellamount += $extra->qty * $extra->price;
    }
@endphp

<!doctype html>
<html lang="en">

<head>
    <title>Pos User analytics</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    {{-- <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}"> --}}
    <meta name="robots" content="noindex, nofollow" />

    <style>
        .card {
            text-align: center;
            padding: 20px;
            width: 100%;
            border-radius: 10px;
            border: 2px solid #EF5927 !important;
            transition: .2s ease-in;
            margin-bottom: 15px;
        }

        .card:hover {
            box-shadow: 5px 5px #EF5927;
        }

        .card h3 {
            text-transform: uppercase;
            font-weight: bold;
            margin: 0px;
            font-size: 24px;
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

        /* Improved Compact Order Card Styles */
        .order-card {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 12px;
            background: #fff;
            transition: all 0.2s ease;
            position: relative;
        }

        .order-card:hover {
            box-shadow: 0 2px 8px rgba(239, 89, 39, 0.15);
            border-color: #EF5927;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
            flex-wrap: wrap;
            gap: 6px;
        }

        .order-id {
            font-size: 14px;
            font-weight: bold;
            color: #EF5927;
            background: rgba(239, 89, 39, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
        }

        .order-invoice {
            font-size: 13px;
        }

        .order-invoice a {
            color: #666;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .order-invoice a:hover {
            color: #EF5927;
        }

        .customer-info {
            margin-bottom: 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .customer-name {
            font-size: 15px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .customer-contact {
            display: flex;
            gap: 8px;
            font-size: 12px;
        }

        .customer-contact a {
            color: #666;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .customer-contact a:hover {
            color: #EF5927;
            text-decoration: underline;
        }

        .order-description {
            margin-bottom: 8px;
            font-size: 13px;
        }

        .order-description ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .order-description li {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
        }

        .order-description li span:first-child {
            color: #666;
        }

        .order-description li span:last-child {
            font-weight: 500;
            color: #333;
        }

        .order-note {
            font-size: 12px;
            color: #666;
            margin: 8px 0;
            padding: 6px;
            background: #f9f9f9;
            border-radius: 4px;
            position: relative;
            padding-left: 24px;
        }

        .order-note:before {
            content: "!";
            position: absolute;
            left: 8px;
            top: 6px;
            width: 16px;
            height: 16px;
            background: #EF5927;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: bold;
        }

        .order-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .order-actions .btn {
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 4px;
            flex: 1;
            min-width: 80px;
            max-width: 120px;
        }

        /* Status badges */
        .order-status {
            position: absolute;
            top: 12px;
            right: 12px;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 4px;
            background: #f5f5f5;
            color: #666;
        }

        .order-status.marked {
            background: #fff8e6;
            color: #e6a700;
        }

        .order-status.resolved {
            background: #e6f7ee;
            color: #00a854;
        }

        /* Mobile Responsive Adjustments */
        @media (max-width: 768px) {
            .order-card {
                padding: 10px;
            }

            .customer-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .customer-contact {
                flex-direction: column;
                gap: 4px;
                align-items: flex-start;
            }

            .order-actions .btn {
                min-width: 100%;
                max-width: 100%;
            }

            .order-status {
                position: static;
                margin-bottom: 6px;
            }
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .card h3 {
                font-size: 16px;
            }

            .card h1 {
                font-size: 28px;
            }

            h1 {
                font-size: 24px;
            }

            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .form-group {
                margin-bottom: 10px;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .customer-name {
                font-size: 16px;
            }

            .order-actions {
                flex-direction: column;
                gap: 5px;
            }

            .order-actions .btn {
                width: 100%;
                padding: 6px 8px;
            }

            .row {
                margin-left: -5px;
                margin-right: -5px;
            }

            .col-md-3,
            .col-md-4,
            .col-md-6 {
                padding-left: 5px;
                padding-right: 5px;
            }

            .orders-container {
                margin-top: 10px !important;
            }
        }
    </style>
</head>

<body>
    <header></header>
    <main>
        {{-- @section('javascript')
            <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
            <script>
                var table = $('#dataTable').DataTable()
            </script>
        @endsection --}}
        <form action="{{ url()->current() }}" method="get" id="form1">
            <div class="container mt-4 mb-5">
                <h1>
                    Pos Report - <span style="color: #EF5927">{{ $user->email }} </span>
                </h1>

                <div class="row">
                    <div class="col-md-3">

                        <div class="form-group">
                            <label for="date">Select Date</label>
                            <input value="{{ request()->date }}" onchange="document.getElementById('form1').submit()"
                                name="date" type="date" id="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">

                        <div class="form-group">
                            <label for="event">Select Event</label>
                            <select onchange="document.getElementById('form1').submit()" name="event" id="event"
                                class="form-control">
                                <option value="">Select Event</option>
                                @foreach ($events as $event)
                                    <option @if ($event->id == request()->event) selected @endif
                                        value="{{ $event->id }}">
                                        {{ $event->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>


                @if (request()->filled('event'))
                    <hr>

                    <div class="container">
                        <div class="row g-3 mb-3">
                            <div class="col-6 col-md-4">
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
                                    'value' => Sohoj::price($cardAmount),
                                ])
                            </div>

                            <div class="col-md-4">
                                @include('vendor.voyager.events.partial.card', [
                                    'label' => 'Cash Amount',
                                    'value' => Sohoj::price($cashAmount),
                                ])
                            </div>
                            <div class="col-md-4">
                                @include('vendor.voyager.events.partial.card', [
                                    'label' => 'QR Amount',
                                    'value' => Sohoj::price($qrAmount),
                                ])
                            </div>
                            <div class="col-6 col-md-4">
                                @include('vendor.voyager.events.partial.card', [
                                    'label' => 'Total Ticket Sell',
                                    'value' => $tickets->count(),
                                ])

                            </div>
                            <div class="col-6 col-md-4">
                                @include('vendor.voyager.events.partial.card', [
                                    'label' => 'Total Product sell',
                                    'value' => $extras->sum('qty'),
                                ])
                            </div>
                            <div class="col-6 col-md-4">
                                @include('vendor.voyager.events.partial.card', [
                                    'label' => 'Product sell Amount',
                                    'value' => Sohoj::price($productsellamount),
                                ])

                            </div>
                            <div class="col-12    col-md-4">
                                @include('vendor.voyager.events.partial.card', [
                                    'label' => 'Ticket sell Amount',
                                    'value' => Sohoj::price($orders->sum('total') - $productsellamount),
                                ])
                            </div>
                            <div class="col-md-4">
                                @include('vendor.voyager.events.partial.card', [
                                    'label' => 'Total Paid Invite ',
                                    'value' => $totalPaidInvite->count(),
                                ])
                            </div>

                            <div class="col-md-4">
                                @include('vendor.voyager.events.partial.card', [
                                    'label' => 'Total Paid Invite Amount',
                                    'value' => Sohoj::price($totalPaidInvite->sum('price')),
                                ])
                            </div>
                            <h1 class="p-3">
                                {{ __('words.tickets') }}
                            </h1>
                            <div class="row">
                                @foreach ($tickets->groupBy(fn($ticket) => $ticket->product->name) as $product => $tickets)
                                    <div class="col-12 col-md-4">
                                        <div class="card">
                                            <h3>
                                                {{ $product }}
                                            </h3>
                                            <h1>
                                                {{ count($tickets) }}
                                            </h1>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <h1 class="p-3">
                                {{ __('words.extras') }}
                            </h1>
                            <div class="row">
                                @foreach ($extras->groupBy('name') as $name => $data)
                                    <div class="col-12 col-md-4">
                                        <div class="card">
                                            <h3>
                                                {{ $name }}
                                            </h3>
                                            <h1>
                                                {{ $data->sum('qty') }}
                                            </h1>
                                        </div>
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

                        </div>

                        <div class="card">

                            <div class="row text-left mb-0">
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <input value="{{ request()->search }}"
                                            onchange="document.getElementById('form1').submit()" type="text"
                                            id="search" name="search" class="form-control"
                                            placeholder="Search here">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group m-0">
                                        <select onchange="document.getElementById('form1').submit()" name="alert"
                                            id="alert" class="form-control">
                                            <option value="">Alert</option>
                                            <option @if (request()->alert == 'marked') selected @endif value="marked">
                                                Marked
                                            </option>
                                            <option @if (request()->alert == 'unmarked') selected @endif value="unmarked">
                                                Not marked
                                            </option>
                                            <option @if (request()->alert == 'resolved') selected @endif value="resolved">
                                                Resolved
                                            </option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="orders-container mt-4">
                                @if ($app)
                                    @foreach ($allorders as $order)
                                        <div class="order-card">
                                            <div class="order-header">
                                                <div class="order-id">Order #{{ $order->id }}</div>
                                                <div class="order-invoice">
                                                    @if (!empty($order->invoice_url) && !empty($order->invoice_id))
                                                        <a href="{{ $order->invoice_url }}"
                                                            class="btn btn-sm btn-outline-primary">View Invoice
                                                            #{{ $order->invoice_id }}</a>
                                                    @else
                                                        <span class="text-muted">No Invoice</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="customer-info">
                                                <div class="customer-name">{{ $order->user->name }}</div>
                                                <div class="customer-contact">
                                                    <a
                                                        href="mailto:{{ $order->billing->email ?? $order->user->email }}">
                                                        {{ $order->billing->email ?? $order->user->email }}
                                                    </a>
                                                    <br>
                                                    <a
                                                        href="tel:{{ $order->billing->phone ?? $order->user->contact_number }}">
                                                        {{ $order->billing->phone ?? $order->user->contact_number }}
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="order-description">
                                                <ul>
                                                    @foreach ($order->getDescription() as $line)
                                                        <li>{{ $line }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            @if ($order->note)
                                                <div class="order-note mb-3">
                                                    <strong>Note:</strong> {{ $order->note }}
                                                </div>
                                            @endif

                                            <div class="order-actions">
                                                @if ($order->alert == 'unmarked')
                                                    <button type="button" class="btn btn-primary ticket-marked-button"
                                                        data-url="{{ route($app ? 'app.order.marked' : 'order.marked', ['order' => $order, 'token' => $token]) }}"
                                                        data-bs-toggle="modal" data-bs-target="#ticket-marked">
                                                        Mark
                                                    </button>
                                                @elseif($order->alert == 'resolved')
                                                    <button class="btn btn-success">Resolved</button>
                                                @else
                                                    <button class="btn btn-danger">Marked</button>
                                                @endif

                                                <span class="d-none" id="ticket-action-url-{{ $order->id }}"
                                                    data-email-url="{{ route($app ? 'app.order.email' : 'order.email', ['order' => $order, 'token' => $token]) }}"
                                                    data-sms-url="{{ route($app ? 'app.order.sms' : 'order.sms', ['order' => $order, 'token' => $token]) }}"></span>

                                                <button type="button" class="btn btn-primary ticket-action-button"
                                                    data-order-no="{{ $order->id }}"
                                                    data-has-product="{{ $order->tickets_count === 0 ? 0 : 1 }}"
                                                    data-url="{{ route($app ? 'app.order.update' : 'order.update', ['order' => $order, 'token' => $token]) }}"
                                                    data-email="{{ $order->billing->email ?? $order->user->email }}"
                                                    data-phone="{{ $order->billing->phone ?? $order->user->contact_number }}"
                                                    data-bs-toggle="modal" data-bs-target="#action-modal">
                                                    Action
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="table-responsive">

                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="">
                                                    <th>
                                                        #
                                                    </th>
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
                                                @foreach ($allorders as $order)
                                                    <tr>
                                                        <td>
                                                            {{ $order->id }}
                                                        </td>
                                                        <td>{{ $order->user->name }}</td>
                                                        <td>{{ $order->billing->email ?? $order->user->email }}</td>
                                                        <td>{{ $order->billing->phone ?? $order->user->contact_number }}
                                                        </td>
                                                        <td>
                                                            <ul>
                                                                @foreach ($order->getDescription() as $line)
                                                                    <li>
                                                                        {{ $line }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            @if (!empty($order->invoice_url) && !empty($order->invoice_id))
                                                                <a href="{{ $order->invoice_url }}">Invoice
                                                                    #{{ $order->invoice_id }}</a>
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td>{{ $order->note }}</td>
                                                        <td>
                                                            @if ($order->alert == 'unmarked')
                                                                <button type="button"
                                                                    class="btn btn-primary ticket-marked-button"
                                                                    data-url="{{ route('order.marked', ['order' => $order, 'token' => $token]) }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#ticket-marked">
                                                                    Mark
                                                                </button>
                                                            @elseif($order->alert == 'resolved')
                                                                <button class="btn btn-success">Resolved</button>
                                                            @else
                                                                <button class="btn btn-danger">Marked</button>
                                                            @endif
                                                            <span class="d-none"
                                                                id="ticket-action-url-{{ $order->id }}"
                                                                data-email-url="{{ route('order.email', ['order' => $order, 'token' => $token]) }}"
                                                                data-sms-url="{{ route('order.sms', ['order' => $order, 'token' => $token]) }}"></span>
                                                            <button type="button"
                                                                class="btn btn-primary ticket-action-button"
                                                                data-order-no="{{ $order->id }}"
                                                                data-has-product="{{ $order->tickets_count === 0 ? 0 : 1 }}"
                                                                data-url="{{ route('order.update', $order) }}"
                                                                data-email="{{ $order->billing->email ?? $order->user->email }}"
                                                                data-phone="{{ $order->billing->phone ?? $order->user->contact_number }}"
                                                                data-bs-toggle="modal" data-bs-target="#action-modal">
                                                                Action
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                @endif
                            </div>

                            {{ $allorders->withQueryString()->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>

        </form>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>

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

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        const emailTicketBtn = document.getElementById("email-ticket");
        emailTicketBtn.addEventListener('click', e => {
            const csk = confirm('Are you sure?');

            if (!csk) {
                return;
            }

            const url = document.getElementById(`ticket-action-url-${e.target.dataset.orderNo}`).dataset.emailUrl;
            axios.put(url).then(res => toastr.success('Email send to the user.'))

        });
        const sendSmsTicketBtn = document.getElementById("send-sms-ticket");
        sendSmsTicketBtn.addEventListener('click', e => {
            const csk = confirm('Are you sure?');

            if (!csk) {
                return;
            }

            const url = document.getElementById(`ticket-action-url-${e.target.dataset.orderNo}`).dataset.smsUrl;
            axios.put(url).then(res => toastr.success('SMS send to the user.'))

        });

        const ticketTableBody = document.getElementById("ticket-table-body");
        const ordersContainer = document.querySelector(".orders-container");

        // Function to handle URL parameter preservation
        function preserveUrlParams(formEl) {
            const currentUrl = new URL(window.location.href);
            const searchParams = currentUrl.searchParams;

            // Create hidden inputs for each URL parameter
            searchParams.forEach((value, key) => {
                if (key !== 'note') { // Skip note parameter as it's already in the form
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    formEl.appendChild(input);
                }
            });
        }

        // Handle table view clicks
        if (ticketTableBody) {
            ticketTableBody.addEventListener('click', (e) => {
                const el = e.target;
                if (el.classList.contains('ticket-marked-button')) {
                    const url = el.dataset.url;
                    const formEl = document.getElementById('ticket-marked-form');
                    formEl.action = url;
                    preserveUrlParams(formEl);
                    return;
                }

                if (el.classList.contains('ticket-action-button')) {
                    const url = el.dataset.url;
                    const hasProduct = el.dataset.hasProduct;

                    if (hasProduct === '0') {
                        emailTicketBtn.classList.add('d-none')
                    }

                    if (hasProduct !== '0') {
                        emailTicketBtn.classList.remove('d-none')
                    }

                    if (!el.dataset.phone) {
                        sendSmsTicketBtn.classList.add('d-none')
                    }

                    if (el.dataset.phone) {
                        sendSmsTicketBtn.classList.remove('d-none')
                    }

                    emailTicketBtn.dataset.orderNo = el.dataset.orderNo;
                    sendSmsTicketBtn.dataset.orderNo = el.dataset.orderNo;

                    const formEl = document.getElementById('ticket-action-form');
                    const emailEl = formEl.querySelector('[name=email]');
                    const phoneEl = formEl.querySelector('[name=phone]');

                    emailEl.value = el.dataset.email;
                    phoneEl.value = el.dataset.phone;

                    formEl.action = url;
                    return;
                }
            });
        }

        // Handle card view clicks
        if (ordersContainer) {
            ordersContainer.addEventListener('click', (e) => {
                const el = e.target;
                if (el.classList.contains('ticket-marked-button')) {
                    const url = el.dataset.url;
                    const formEl = document.getElementById('ticket-marked-form');
                    formEl.action = url;
                    preserveUrlParams(formEl);
                    return;
                }

                if (el.classList.contains('ticket-action-button')) {
                    const url = el.dataset.url;
                    const hasProduct = el.dataset.hasProduct;

                    if (hasProduct === '0') {
                        emailTicketBtn.classList.add('d-none')
                    }

                    if (hasProduct !== '0') {
                        emailTicketBtn.classList.remove('d-none')
                    }

                    if (!el.dataset.phone) {
                        sendSmsTicketBtn.classList.add('d-none')
                    }

                    if (el.dataset.phone) {
                        sendSmsTicketBtn.classList.remove('d-none')
                    }

                    emailTicketBtn.dataset.orderNo = el.dataset.orderNo;
                    sendSmsTicketBtn.dataset.orderNo = el.dataset.orderNo;

                    const formEl = document.getElementById('ticket-action-form');
                    const emailEl = formEl.querySelector('[name=email]');
                    const phoneEl = formEl.querySelector('[name=phone]');

                    emailEl.value = el.dataset.email;
                    phoneEl.value = el.dataset.phone;

                    formEl.action = url;
                    return;
                }
            });
        }

        let _hasDataChange = false;

        const ticketActionForm = document.getElementById('ticket-action-form');
        ticketActionForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const formEl = e.target;
            const phone = formEl.querySelector('[name=phone]').value;
            const email = formEl.querySelector('[name=email]').value;

            axios.put(formEl.action, {
                    phone,
                    email
                })
                .then(res => {
                    toastr.success('Successfully updated');
                    _hasDataChange = true;
                })
                .catch(err => {
                    if (err.status !== 422) {
                        throw err;
                    }

                    const errors = err.response.data.errors;

                    for (const property in errors) {
                        const msg = errors[property][0];
                        toastr.error(msg);

                    }

                });

        });

        const myModalEl = document.getElementById('action-modal')
        myModalEl.addEventListener('hidden.bs.modal', event => {
            if (_hasDataChange) {
                location.reload()
            }

        });
    </script>
</body>

</html>
