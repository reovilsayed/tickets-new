<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: "Lato", serif;
            background-color: #001232;
        }

        .cus-card {
            overflow: scroll;
            margin: 0px auto;
            max-width: 500px;
            height: 80vh;
            background-color: #e0e0e0;

            box-shadow: 5px 5px 1px #f3510b;
        }

        .cus-card-header {
            background: rgb(243, 81, 11);
            background: -moz-linear-gradient(10deg, rgba(243, 81, 11, 0.7019140419839811) 0%, rgba(243, 81, 11, 0.17250227727809875) 60%);
            background: -webkit-linear-gradient(10deg, rgba(243, 81, 11, 0.7019140419839811) 0%, rgba(243, 81, 11, 0.17250227727809875) 60%);
            background: linear-gradient(10deg, rgba(243, 81, 11, 0.7019140419839811) 0%, rgba(243, 81, 11, 0.17250227727809875) 60%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#f3510b", endColorstr="#f3510b", GradientType=1);
        }

        .event-thumbnail {

            text-align: center;
        }

        .event-thumbnail>img {

            width: 100%;
            height: 250px;
            object-fit: cover;


        }

        .cus-btn-bar {
            display: flex;
            gap: 10px;
            cursor: all-scroll;
            padding: 15px;
            overflow: scroll;
            text-align: center;

            scrollbar-width: none;
        }

        .cus-btn-bar::-webkit-scrollbar {
            display: none;
        }

        .cus-btn {
            flex-shrink: 0;
            font-size: 15px;
            color: #e0e0e0;
            background-color: #f3510b;
            padding: 10px 10px;

            text-decoration: none;
            transition: background-color .2s ease-in, color .2s ease-in;
        }

        .cus-btn:hover {
            background-color: #e0e0e0;
            color: #f3510b;
        }

        .bdr {
            height: 2px;
            background-color: #f3510b;
            width: 50%;
        }
    </style>
    <title>My Digital Wallet</title>
</head>

<body>
    <main class="py-5">



        <select id="eventFilter" class="form-select mt-2 mx-auto  mb-3" style="max-width: 500px">
            @foreach ($events as $id => $tickets)
                <option value="{{ $id }}" {{ $id == $selectedEventId ? 'selected' : '' }}>
                    {{ App\Models\Event::find($id)->name }}
                </option>
            @endforeach
        </select>

        @foreach ($events as $id => $tickets)
            @if ($id == $selectedEventId)

                @php
                    $model = App\Models\Event::find($id);
                @endphp
                <div class="cus-card">
                    <div class="cus-card-header">
                        <div class="event-thumbnail">
                            <img src="{{ Storage::url($model->thumbnail) }}" alt="">
                        </div>
                        <h3 class="my-2 text-center text-light fw-light">
                            {{ $model->name }}
                        </h3>
                        <div class="cus-btn-bar">
                            <a class="cus-btn" href="{{ route('digital-wallet', $order) }}"><i
                                    class="fa-solid fa-qrcode"></i>
                                {{ __('words.tickets') }}</a>
                            <a class="cus-btn"
                                href="{{ route('digital-wallet', ['order' => $order, 'tab' => 'invoice']) }}"><i
                                    class="fa-solid fa-file-invoice"></i>
                                {{ __('words.invoice') }}</a>
                            <a class="cus-btn"
                                href="{{ route('digital-wallet', ['order' => $order, 'tab' => 'info']) }}"><i
                                    class="fa-solid fa-circle-info"></i>
                                {{ __('words.information') }}</a>
                            <a class="cus-btn"
                                href="{{ route('digital-wallet', ['order' => $order, 'tab' => 'products']) }}"><i
                                    class="fa-solid fa-box"></i>
                                {{ __('words.products') }}</a>
                        </div>
                    </div>
                    @if (request()->tab == 'info')
                        <div class="cus-card-body p-2">

                            <div class="card mb-2">
                                <div class="card-body">
                                    <p class="p-0 m-0 fs-6">
                                        {{ $model->start_at->diffForHumans() }}
                                    </p>
                                    <p class="fs-4 fw-bold">
                                        {{ $model->start_at->format('d M - H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <p class="p-0 m-0 fs-6">
                                        {{ __('words.location') }}
                                    </p>
                                    <p class="p-0 m-0 fs-4">
                                        {{ $model->location }}
                                    </p>

                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <p class="p-0 m-0 fs-6">
                                        {{ __('words.website') }}
                                    </p>
                                    <a href="{{ $model->website }}" style="text-decoration: none" class="p-0 m-0 fs-4">
                                        {{ __('words.visit_website') }}
                                    </a>

                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <p class="p-0 m-0 fs-6 fw-bold">
                                        {{ __('words.description') }}
                                    </p>
                                    <hr>
                                    <p class="p-0 m-0 fs-4">
                                        {!! $model->description !!}
                                    </p>

                                </div>
                            </div>
                        </div>
                    @elseif(request()->tab == 'products')
                        <div class="cus-card-body p-2">
                            @if (count($order->tickets->pluck('extras')->flatMap(fn($extra) => $extra)->groupBy('name')))
                                <table class="table  table-bordered w-50 mx-auto text-center">

                                    @foreach ($order->tickets->pluck('extras')->flatMap(fn($extra) => $extra)->groupBy('name') as $name => $extras)
                                        <div class="card  mb-3  shadow-sm " style="border:1px solid #f3510b;">
                                            <div class="card-body">
                                                <h4>
                                                    {{ $name }}
                                                </h4>
                                                <p>
                                                    {{ __('words.remaining') }} :
                                                    {{ $extras->sum('qty') - $extras->sum('used') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h3 class="text-center p-5">
                                        <i class="fa fa-box"></i> {{ __('words.no_product_found') }}
                                    </h3>
                            @endif
                        </div>
                    @elseif(request()->tab == 'invoice')
                        <div class="cus-card-body p-2">

                            <div class="fw-light fs-6 d-flex gap-2 flex-wrap justify-content-start">
                                @if ($order->payment_status)
                                    <div class="badge bg-primary p-2">
                                        {{ __('words.paid_on') }} : {{ $order->date_paid?->format(' d F') ?? 'N/A' }}
                                    </div>
                                @endif
                                <div class="badge bg-primary p-2">
                                    {{ __('words.placed_on') }} : {{ $order->created_at->format(' d F') }}
                                </div>

                                <div class="badge bg-primary p-2">
                                    {{ __('words.updated') }} : {{ $order->updated_at->format(' d F') }}
                                </div>
                            </div>
                            <h2 class="fw-light text-end mt-3" style="color: #f3510b">
                                {{ __('words.invoice') }} #{{ $order->id }}
                            </h2>
                            <div class="card">
                                <div class="card-body">
                                    <p class="fw-light fs-6 mb-0">
                                        {{ __('words.toc_online_id') }} :
                                    </p>
                                    <p class="fw-bold fs-4 mb-0">
                                        {{ $order->invoice_id ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <p class="fw-light fs-6 mb-0">
                                        {{ __('words.toc_online_invoice') }} :
                                    </p>
                                    <a class="fw-bold fs-5 mb-0" style="text-decoration: none"
                                        href="
                                {{ $order->invoice_url }}">{{ __('words.view_invoice') }}</a>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <p class="fw-light fs-6 mb-0">
                                        {{ __('words.billing_information') }} :
                                    </p>
                                    <ul style="list-style: none" class="mt-2">
                                        <li>
                                            <span class="text-primary">{{ __('words.name') }} : </span>
                                            {{ @$order->billing?->name ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <span class="text-primary"> {{ __('words.vat_number') }} :</span>
                                            {{ @$order->billing?->vatNumber ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <span class="text-primary"> {{ __('words.address') }} :</span>
                                            {{ $order->billing->address ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <span class="text-primary"> {{ __('words.payment_status') }} :</span>
                                            {{ $order->payment_status ? 'Paid' : 'Not Paid' }}
                                        </li>
                                        <li>
                                            <span class="text-primary"> {{ __('words.payment_method') }} :</span>
                                            {{ $order->payment_method_title }}
                                        </li>
                                        <li>
                                            <span class="text-primary"> {{ __('words.trnx_id') }} :</span>
                                            {{ $order->transaction_id ?? 'N/A' }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    @foreach ($order->tickets->groupBy('product_id') as $id => $tickets)
                                        @php
                                            $model = App\Models\Product::find($id);
                                        @endphp
                                        <h4 style="color:#000;font-weight:700;">
                                            Ticket : {{ $model->name }}
                                        </h4>
                                        <small class="pill pill-success">
                                            Event : {{ $model->event->name }}
                                        </small>
                                        <br>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <tr>
                                                    <th>
                                                        {{ __('words.ticket_id') }}
                                                    </th>
                                                    <th>
                                                        {{ __('words.paymeys_status') }}
                                                    </th>
                                                    <th>
                                                        {{ __('words.payment_type') }}
                                                    </th>
                                                    <th>
                                                        {{ __('words.status') }}
                                                    </th>
                                                    <th>
                                                        {{ __('words.price') }}
                                                    </th>

                                                </tr>

                                                @foreach ($tickets as $ticket)
                                                    <tr>

                                                        <td>
                                                            {{ $ticket->ticket }}
                                                        </td>
                                                        <td>

                                                            <span
                                                                class="pill pill-{{ $order->payment_status ? 'success' : 'danger' }}">
                                                                {{ $order->payment_status ? 'Paid' : 'Not Paid' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ $order->payment_method_title }}

                                                        </td>
                                                        <td>
                                                            {{ $ticket->status() }}

                                                        </td>
                                                        <td>
                                                            {{ Sohoj::price($ticket->price) }}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                @foreach ($order->getExtras() as $extra)
                                                    <tr>

                                                        <td>
                                                            {{ $extra->display_name }} *
                                                            {{ $extra->purchase_quantity }}
                                                        </td>
                                                        <td>

                                                            <span
                                                                class="pill pill-{{ $order->payment_status ? 'success' : 'danger' }}">
                                                                {{ $order->payment_status ? 'Paid' : 'Not Paid' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            {{ $order->payment_method_title }}

                                                        </td>
                                                        <td>
                                                            N/A

                                                        </td>
                                                        <td>
                                                            {{ Sohoj::price($extra->purchase_price) }}
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">

                                    <table class="payinfo table">
                                        <tr>
                                            <th style="font-size: 14px">
                                                {{ __('words.subtotal') }}
                                            </th>
                                            <td style="font-size: 14px">
                                                + {{ Sohoj::price($order->subtotal) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="font-size: 14px">
                                                {{ __('words.tax') }}
                                            </th>
                                            <td style="font-size: 14px">
                                                + {{ Sohoj::price($order->tax) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="font-size: 14px">
                                                {{ __('words.discount') }}
                                            </th>
                                            <td style="font-size: 14px">
                                                - {{ Sohoj::price($order->discount) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="font-size: 18px">
                                                {{ __('words.total') }}
                                            </th>
                                            <td style="font-size: 18px">
                                                = {{ Sohoj::price($order->total) }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="cus-card-body p-2">
                            @foreach ($tickets->groupBy('product_id') as $id => $tickets)
                                @php
                                    $product = App\Models\Product::find($id);
                                @endphp

                                <div class="card mb-3  shadow-sm " style="border:1px solid #f3510b;">




                                    <div class="card-body">
                                        <a style="text-decoration:none;color: #f3510b;" class="float-end"
                                            data-bs-toggle="collapse" href="#seeDetails{{ $product->id }}"
                                            role="button" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fa fa-chevron-down"></i>
                                        </a>
                                        <p class="fw-normal mb-1 fs-4">
                                            {{ $product->name }} &nbsp;<span style="font-size: 14px"
                                                class=" badge bg-secondary px-2 py-1 ">X
                                                {{ $tickets->count() }}</span>
                                        </p>
                                        <p class=" text-secondary" style="font-size: 14px">
                                            <i class="far fa-calendar"></i> &nbsp;
                                            {{ $product->start_date->format(' d F H:i') }}
                                        </p>
                                        <p>

                                            <a style="color:  #f3510b;text-decoration:none"
                                                href="{{ route('download.ticket', ['order' => $order, 'p' => $product->id]) }}">{{ __('words.view_tickets') }}</a>
                                        </p>

                                        <div class="collapse" id="seeDetails{{ $product->id }}">

                                            {!! $product->description !!}

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @endif
                </div>
            @endif
        @endforeach

    </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"
        integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.getElementById('eventFilter').addEventListener('change', function() {
            const selectedEventId = this.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('event_id', selectedEventId);
            window.location.href = currentUrl;
        });
    </script>

</body>

</html>
