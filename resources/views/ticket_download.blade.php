<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your tickets</title>

    <style>
        @font-face {
            font-family: montserrat;
            src: url(assets\frontend-old-assets\fonts\montserrat\Montserrat-Regular.ttf);
        }

        :root {
            --primary-color: #ef5927;
            --secondary-color: #ff990a;
            --dark-color: #221e1f;
        }

        @font-face {
            font-family: 'Montserrat';
            font-style: normal;
            font-weight: normal;
            src: url(https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap) format('truetype');
        }

        * {
            margin: 0;
            padding: 0;
          
        }
        p,li{
            font-size: 10px !important;
        }
        
        body {
            font-family: "montserrat", sans-serif !important;
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
            font-size: 18px;
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
            font-size: 20px;
            margin-bottom: 15px;
        }

        .event-title h5 {
            font-size: 16px;
        }

        .logo {
            height: 30px;
            width: 60px;
            margin-bottom: 30px;
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
            font-size: 16px;
            /* font-weight: bold; */
        }

        .event-qr-code>p {
            font-size: 14px;
        }

        @media print {
            .container {
                height: 100vh;
            }
        }

        .pagebreak {
            page-break-after: always;
        }
        .avoidpagebreak{
            
            page-break-after: avoid;
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
                                    @if (!$ticket->product->start_date->isSameDay($ticket->product->end_date))
                                    <p class="date"  style="font-size: 16px !important;">{{ $ticket->product->start_date->format('M d, Y') }}</p>
                                    <p class="text-sub"  style="font-size: 10px !important;">{{ __('words.to') }}</p>
                                    <p class="date"  style="font-size: 16px !important;">{{ $ticket->product->end_date->format('M d, Y') }}</p>
                                    @else
                                    <p class="date"  style="font-size: 16px !important;">{{ $ticket->product->start_date->format('M d, Y') }}</p>
                                    @endif

                                    <p class="country" style="font-size: 16px !important;">{{ $ticket->event->city }}</p>
                                    <p class="price" style="font-size: 28px !important;">&#8364;{{ $ticket->product->price }}</p>
                                    <p class="text-main" style="font-size: 14px !important;">{{ __('words.final_price') }}</p>
                                    <p class="text-sub" style="font-size: 10px !important;">{{ __('words.tax_include') }}</p>
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
            @if ($ticket->event->banner)
            <div class="content">
                <img src="{{public_path('storage/'.$ticket->event->banner)}}" alt="" style="width: 100%">
                {{-- <img class="logo" src="D:/laragon/www/tickets-new/public/storage/events/January2025/8dbF18adCDeFJCjx2VOV.jpg" alt=""> --}}
            </div>
            @endif
            <div class="content">
                <h2 style="font-size: 18px">
                    {{ __('words.description') }}
                </h2>
                <p>{!! $ticket->product->description !!}</p>

<br>
                <h2 style="font-size: 18px !important;">{{ __('words.term') }}</h2>
                <p>{!! $ticket->event->terms !!}</p>
        
                <br>
                <h2 style="font-size: 18px !important;">{{ __('words.address') }}</h2>
                <p class="address" style="font-size: 18px !important;">{{ $ticket->event->location }}</p>
            </div>
        </div>
        @if ($loop->last == false)
            <div class="pagebreak"></div>
            @else
            <div class="avoidpagebreak"></div>

        @endif
    @endforeach
</body>

</html>
