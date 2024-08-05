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
                <div class="col-xxl-6 col-xl-8 mx-auto my-3">

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
                                            <li class="text-content"><span class="theme-color"> Email :</span>
                                                {{ Auth::user()->email }}</li>
                                            <li class="text-content"><span class="theme-color"> Create Date
                                                    : </span>
                                                {{ $order->created_at->format('M d, Y') }}</li>

                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="header-right">
                                <h3>Invoice</h3>

                            </div>

                        </div>
                        <div class="invoice-body">
                            <div class="table-responsive">
                                <table class="table table-product mb-0">
                                    <thead>
                                        <tr>
                                            <th>
                                                Ticket ID
                                            </th>
                                            <th>
                                                Payment Status
                                            </th>
                                            <th>
                                                Payment Type
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th>
                                                Price
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
                                                    Paid
                                                </td>
                                                <td>
                                                    Visa

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
                                            <td colspan="2">TOTAL :</td>
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
                                            onclick="window.print();">Print</button>
                                    </li>
                                </ul>
                            </div>
                            {{-- <div class="support-box">
                                    <ul>
                                        <li>
                                            <div class="support-detail">
                                                <div class="support-icon">
                                                    <i class="fa-solid fa-phone"></i>
                                                </div>
                                                <div class="support-content">
                                                    <ul>
                                                        <li>+91 643-387-826</li>
                                                        <li>+91 643-387-826</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="support-detail">
                                                <div class="support-icon">
                                                    <i class="fa-solid fa-earth-americas"></i>
                                                </div>
                                                <div class="support-content">
                                                    <ul>
                                                        <li>support@fastkart.com</li>
                                                        <li>www.fastkart.com</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="support-detail">
                                                <div class="support-icon">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                </div>
                                                <div class="support-content">
                                                    <ul>
                                                        <li>Fastkart Store</li>
                                                        <li>Store India-2768283</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</body>



</html>
