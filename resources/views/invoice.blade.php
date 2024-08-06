<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/images/icon.png" type="image/x-icon">
    <title>Event-Ticket</title>

    <!--Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="assets/css/invoice/style.css">

</head>

<body class="bg-light">
    <section class="theme-invoice-3">
        <div class="container">
            <div class="row">
                <div class="col-xxl-6 col-xl-8 col-sm-10 mx-auto my-3">

                    <div class="invoice-wrapper">
                        <div class="invoice-header">

                            <div class="header-left" style="height: 150px; width:150px;">
                                <img src="assets/logo-black.png" class="img-fluid" alt="">
                            </div>
                            <div class="header-left">
                                <div class="header-address">
                                    <div class="address-right">
                                        <ul>
                                            <h2 class="theme-color mb-2"> {{ auth()->user()->name }}</h2>
                                            <li class="text-content"><span class="theme-color">{{ __('words.email') }}
                                                    :</span>
                                                {{ Auth::user()->email }}</li>
                                            <li class="text-content"><span class="theme-color">
                                                    {{ __('words.create_date') }}
                                                    : </span>
                                                {{ $order->created_at->format('M d, Y') }}</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="header-right">
                                <h3>{{ __('words.invoice') }}</h3>

                            </div>

                        </div>
                        <div class="invoice-body">
                            <div class="table-responsive">
                                <table class="table table-product mb-0">
                                    <thead>
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

                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $ticket)
                                            <tr>

                                                <td>
                                                    {{ $ticket->ticket }}
                                                </td>
                                                <td>
                                                    {{ __('words.paid') }}
                                                </td>
                                                <td>
                                                    {{ __('words.visa') }}

                                                </td>
                                                <td>
                                                    {{ $ticket->status() }}

                                                </td>
                                                <td>
                                                    {{ Sohoj::price($ticket->price) }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="2">{{ __('words.total') }} :</td>
                                            <td>{{ Sohoj::price($order->total) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-footer">
                            <div class="button-group">
                                <ul>

                                    <li>
                                        <button class="btn text-white print-button rounded ms-2"
                                            onclick="window.print();">{{ __('words.print') }}</button>
                                    </li>
                                </ul>
                            </div>
                         
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</body>



</html>
