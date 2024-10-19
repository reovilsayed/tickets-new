@extends('voyager::master')

@section('page_title', __('voyager::generic.view') . ' ' . $dataType->getTranslatedAttribute('display_name_singular'))
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

@section('page_header')

    @include('voyager::multilingual.language-selector')
@stop

@section('content')

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="icon" href="images/favicon.png" type="image/x-icon">

        <title>Haladeals |Email</title>


    </head>

    <body style="margin: 20px auto;">
        <div class="container">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h1 style="color:#000;font-weight:700;">
                                Order #{{ $dataTypeContent->id }}
                            </h1>
                            <span class="pill pill-{{ $dataTypeContent->getBsStatusClass() }}">
                                {{ $dataTypeContent->getStatus() }}
                            </span>
                            <br>
                            <br>
                            <div style="display: flex;gap:10px;">
                                @if ($dataTypeContent->payment_status)
                                    <span class="pill pill-secondary">
                                        Paid On : {{ $dataTypeContent->date_paid?->format(' d F, Y') ?? 'N/A' }}
                                    </span>
                                @endif
                                <span class="pill pill-secondary">
                                    Placed On : {{ $dataTypeContent->created_at->format(' d F, Y') }}
                                </span>

                                <span class="pill pill-secondary">
                                    Updated : {{ $dataTypeContent->updated_at->format(' d F, Y') }}
                                </span>


                            </div>
                        </div>
                        <div class="col-md-4">

                            <div>
                                <span class="text-primary">
                                    TOC Online ID :
                                </span>
                                <p class="">
                                    {{ $dataTypeContent->invoice_id ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-primary">
                                    TOC Online Invoice :
                                </span>
                                <p class="">
                                    <a href="
                                    {{ $dataTypeContent->invoice_url }}">View
                                        Invoice</a>
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">

                <div class="col-md-6">
                    <div class="panel panel-bordered" style="height: 500px">


                        <div class="panel-body ">
                            <h3 style="color:#000;font-weight:700;">
                                Order Information
                            </h3>
                            <hr>

                            <div>
                                <span class="text-primary">
                                    Name
                                </span>
                                <p class="h4">
                                    {{ $dataTypeContent->billing->name }}
                                </p>
                            </div>
                            <div>
                                <span class="text-primary">
                                    Vat Number
                                </span>
                                <p class="h4">
                                    {{ $dataTypeContent->billing->vatNumber ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-primary">
                                    Address
                                </span>
                                <p class="h4">
                                    {{ $dataTypeContent->billing->address ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-primary">
                                    Payment Status
                                </span>

                                <p style="margin-top:10px ">

                                    <span class="pill pill-{{ $dataTypeContent->payment_status ? 'success' : 'danger' }}">
                                        {{ $dataTypeContent->payment_status ? 'Paid' : 'Not Paid' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <span class="text-primary">
                                    Payment Method
                                </span>
                                <p class="h4">
                                    {{ $dataTypeContent->payment_method_title ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-primary">
                                    Transaction ID
                                </span>
                                <p class="h4">
                                    {{ $dataTypeContent->transaction_id ?? 'N/A' }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-bordered" style="height: 500px">


                        <div class="panel-body ">
                            <h3 style="color:#000;font-weight:700;">
                                User Information
                            </h3>
                            <hr>

                            <div>
                                <span class="text-primary">
                                    Name
                                </span>
                                <p class="h4">
                                    {{ $dataTypeContent->user ? $dataTypeContent->user->name . ' ' . $dataTypeContent->user->l_name : $dataTypeContent->billing->name }}
                                </p>
                            </div>
                            <div>
                                <span class="text-primary">
                                    Email
                                </span>
                                <p class="h4">
                                    {{ $dataTypeContent->user ? $dataTypeContent->user->email ?? 'N/A' : $dataTypeContent->billing->email }}
                                </p>
                            </div>
                            <div>
                                <span class="text-primary">
                                    Country
                                </span>
                                <p class="h4">
                                    {{ @$dataTypeContent?->user?->getCountry() ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-primary">
                                    Vat Number
                                </span>
                                <p class="h4">
                                    {{ @$dataTypeContent?->user?->vatNumber ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <span class="text-primary">
                                    Address
                                </span>
                                <p class="h4">

                                    {{ @$dataTypeContent?->user?->address ?? 'N/A' }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="panel">
                <div class="panel-body">
                    @foreach ($dataTypeContent->tickets->groupBy('product_id') as $id => $tickets)
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
                                                class="pill pill-{{ $dataTypeContent->payment_status ? 'success' : 'danger' }}">
                                                {{ $dataTypeContent->payment_status ? 'Paid' : 'Not Paid' }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $dataTypeContent->payment_method_title }}

                                        </td>
                                        <td>
                                            {{ $ticket->status() }}

                                        </td>
                                        <td>
                                            {{ Sohoj::price($ticket->price) }}
                                        </td>

                                    </tr>
                                @endforeach
                                @foreach ($dataTypeContent->getExtras() as $extra)
                                    <tr>

                                        <td>
                                            {{ $extra->display_name }} * {{ $extra->purchase_quantity }}
                                        </td>
                                        <td>

                                            <span
                                                class="pill pill-{{ $dataTypeContent->payment_status ? 'success' : 'danger' }}">
                                                {{ $dataTypeContent->payment_status ? 'Paid' : 'Not Paid' }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $dataTypeContent->payment_method_title }}

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
            <div class="panel">
                <div class="panel-body">

                    <table class="payinfo table">
                        <tr>
                            <th style="font-size: 14px">
                                {{ __('words.subtotal') }}
                            </th>
                            <td style="font-size: 14px">
                                + {{ Sohoj::price($dataTypeContent->subtotal) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="font-size: 14px">
                                {{ __('words.tax') }}
                            </th>
                            <td style="font-size: 14px">
                                + {{ Sohoj::price($dataTypeContent->tax) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="font-size: 14px">
                                {{ __('words.discount') }}
                            </th>
                            <td style="font-size: 14px">
                                - {{ Sohoj::price($dataTypeContent->discount) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="font-size: 18px">
                                {{ __('words.total') }}
                            </th>
                            <td style="font-size: 18px">
                                = {{ Sohoj::price($dataTypeContent->total) }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>

    </body>

    </html>

@stop

@section('javascript')
    @if ($isModelTranslatable)
        <script>
            $(document).ready(function() {
                $('.side-body').multilingual();
            });
        </script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function(e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) {
                // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/) ?
                deleteFormAction.replace(/([0-9]+$)/, $(this).data('id')) :
                deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });
    </script>
@stop
