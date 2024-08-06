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
            margin: 34%;
            padding: 20px 8px;
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
        <img src="assets/logo.png" alt="Essência Company">
    </div>
    <div class="email-container">
        <div class="email-ticket-boreder"></div>
        <div class="email-content">
            <div style="text-align: right">

                <p>{{ __('words.thank_you_for_purchasing_tickets_to') }}
                    <strong></strong>!{{ __('words.we_are_thrilled_to_have_you_join_us_for_this') }}
                <h1>{{ $product->name }}</h1>
                {{ __('words.exciting_event._Here_are_the_details_of_your_purchase') }}:</p>
                <p><strong>{{ __('words.name') }}:</strong> {{ $product->event->name }} </p>
                <p><strong>{{ __('words.date') }}:</strong> {{ $product->event->start_at->format('d m, Y') }}</p>
                <p><strong>{{ __('words.time') }}:</strong> {{ $product->event->start_at->format('h:i a') }}</p>
                <p><strong>{{ __('words.location') }}:</strong>{{ $product->event->location }}</p>
            </div>
        </div>
        <a href="{{ route('download.ticket', ['order' => $order->id, 'product' => $product->id]) }}"
            class="btn-download">{{ __('words.download_ticket') }}</a>
        <div class="email-footer">
            <p><strong>{{ __('words.ticket_email_note1') }}</p>
            <p>{{ __('words.ticket_email_note2') }}</p>
            <p>{{ __('words.ticket_email_note3') }}</p>
            <p>{{ __('words.ticket_email_note4') }}</p>
        </div>
    </div>
</body>

</html>
