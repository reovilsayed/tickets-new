<!DOCTYPE html>
<html>

<head>
    <title>Event Tickets</title>
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #cccbcb;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
        }

        .email-header {
            text-align: center;
        }

        .email-header img {
            max-width: 200px;
        }

        .email-content {
            padding: 20px;
        }

        .email-content h1 {
            text-align: center;
            color: #e86c3d;
        }

        .email-content p {
            text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;
        }

        .email-footer {
            margin-top: 10px;
            padding: 15px;
            background-color: #ffffff;
            text-align: center;
            font-size: 14px;
            color: #040404;
        }

        .email-footer p {
            color: #5d5b5b;
        }

        .btn-download {
            margin: 10% auto;
            padding: 13px 15px;
            background-color: #e86c3d;
            color: #d5d4d4;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            margin-top: 10px;
        }

        .email-ticket-boreder {
            border: 4px solid #e86c3d;
            width: 98.6%
        }

        .email-footer strong {
            color: #000000
        }

        .email-content strong {
            color: #e86c3d;
        }
    </style>
</head>

<body>
    <div class="email-header">
        <img src="{{ Voyager::image(setting('site.logo_black')) }}" alt="Essência Company">
    </div>
    <div class="email-container">
        <div class="email-ticket-boreder"></div>
        <div class="email-content">
            <div style="text-align: right">
                <h1>{{ __('words.email_title') }}</h1>
                <p>{{ __('words.thank_you_for_purchasing_tickets_to') }} </p>

                <p><strong>{{ __('words.event_name') }}:</strong> {{ $product->event->name }} </p>
                <p><strong>{{ __('words.ticket_name') }}:</strong> {{ $product->name }} </p>
                <p><strong>{{ __('words.date') }}:</strong> {{ $product->start_date->format('d M, Y') }} -
                    {{ $product->end_date->format('d M, Y') }}</p>
                <p><strong>{{ __('words.doors_open') }}:</strong> {{ $product->event->start_at->format('h:i a') }}</p>
                <p><strong>{{ __('words.location') }}:</strong>{{ $product->event->location }}</p>
            </div>
        </div>
        <div class="" style="text-align: center">
            <a href="{{ route('download.ticket', ['order' => $order, 'product' => $product->id]) }}"
                class="btn-download text-white">{{ __('words.download_ticket') }}</a>
        </div>
        <div class="email-footer">
            <p>{{ __('words.footer_text') }} </p>
            <p>{{ __('words.footer_text2') }} </p>
        </div>
    </div>
</body>

</html>
