<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your tickets</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-color: #ef5927;
            --secondary-color: #ff990a;
            --dark-color: #221e1f;
        }

        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Montserrat", sans-serif !important;
            margin: 0;
        }

        .container {
            padding: 40px;
            width: 80%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .content {
            margin: 20px 0;
        }

        table {
            padding: 30px 0;
            border: 2px solid var(--primary-color);
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        table td {
            padding: 10px;
            text-align: center;
        }

        .event-date-and-price,
        .event-title,
        .event-qr-code {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .event-date-and-price .date {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .event-date-and-price .country {
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 3px;
            margin-bottom: 20px;
        }

        .event-date-and-price .price {
            font-size: 26px;
            font-weight: 100;
        }

        .event-title {
            border-right: 2px solid var(--primary-color);
            border-left: 2px solid var(--primary-color);
        }

        .text-main {
            font-weight: 600;
            font-size: 14px;
        }

        .text-sub {
            font-weight: 100;
            font-size: 12px;
        }

        .event-title h1 {
            font-size: 26px;
            margin-bottom: 15px;
        }

        .event-title h5 {
            font-size: 18px;
        }

        .logo {
            height: 30px;
            width: 60px;
        }

        .event-qr-code img {
            margin-bottom: 10px;
        }

        h2 {
            color: var(--secondary-color);
            padding-bottom: 10px;
            margin-bottom: 10px;
            border-bottom: 3px solid var(--secondary-color);
        }

        .content ul {
            padding: 10px 40px;
        }

        .content ul li {
            margin-bottom: 8px;
            font-size: 14px;
        }

        .address {
            font-size: 20px;
            font-weight: bold;
        }

        .event-qr-code>p {
            font-size: 14px;
        }

        @media print {
            .container {
                height: 100vh;
            }
        }
    </style>
</head>

<body>
    @foreach ($tickets as $ticket)
        <div class="container">
            <div class="header">
                <div>
                    <table>
                        <tr>
                            <td style="width: 25%;">
                                <div class="event-date-and-price">
                                    <p class="date">{{ $ticket->product->start_date->format('M d, Y') }}</p>
                                    <p class="text-sub">{{ __('words.to') }}</p>
                                    <p class="date">{{ $ticket->product->end_date->format('M d, Y') }}</p>
                                    <p class="country">{{ $ticket->event->city }}</p>
                                    <p class="price">&#8364;{{ $ticket->product->price }}</p>
                                    <p class="text-main">{{ __('words.final_price') }}</p>
                                    <p class="text-sub">{{ __('words.tax_include') }}</p>
                                </div>
                            </td>
                            <td style="width: 50%;">
                                <div class="event-title">
                                    <img class="logo" src="{{ public_path('assets/logo-black.png') }}" alt="">
                                    <h1>{{ $ticket->event->name }}</h1>
                                    <h5>{{ $ticket->product->name }}</h5>
                                </div>
                            </td>
                            <td style="width: 25%;">
                                <div class="event-qr-code">
                                    <img src="{{ $ticket->qr_code }}" alt="QR Code" height="120" width="120">
                                    <p>{{ $ticket->ticket }}</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="content">
                <h2>{{ __('words.term') }}</h2>
                {!! $ticket->event->terms !!}
                <br>
                <br>
                <h2>{{ __('words.address') }}</h2>
                <p class="address">{{ $ticket->event->location }}</p>
            </div>
        </div>
    @endforeach
</body>

</html>
