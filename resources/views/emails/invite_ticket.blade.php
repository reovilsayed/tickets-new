<!DOCTYPE html>
<html>

<head>
    <title>Event Tickets</title>

</head>

<body style='font-family: "Montserrat", sans-serif;
            background-color: #cccbcb;
            margin: 0;
            padding: 0;'>
    <div class="email-header" style="text-align: center;">
        <img src="{{ Voyager::image(setting('site.logo_black')) }}" alt="Essência Company" style="max-width: 200px;">
    </div>
    <div class="email-container" style=" max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;">
        <div class="email-ticket-boreder" style=" border: 4px solid #e86c3d;
            width: 98.6%"></div>
        <div class="email-content" style=" padding: 20px;">
            <div style="text-align: right">
                <h1 style=" text-align: center;
            color: #e86c3d;">{{ __('words.invite_email_title') }}</h1>
                <p style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;">{{ __('words.invite_thank_you_for_purchasing_tickets_to') }} </p>

                <p style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;"><strong style=" color: #e86c3d;">{{ __('words.invite_event_name') }}:</strong> {{ $product->event->name }} </p>
                <p style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;"><strong style=" color: #e86c3d;">{{ __('words.invite_ticket_name') }}:</strong> {{ $product->name }} </p>
                <p style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;"><strong style=" color: #e86c3d;">{{ __('words.date') }}:</strong> {{ $product->start_date->format('d M, Y') }} -
                    {{ $product->end_date->format('d M, Y') }}</p>
                <p style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;"><strong style=" color: #e86c3d;">{{ __('words.invite_doors_open') }}:</strong> {{ $product->event->start_at->format('h:i a') }}</p>
                <p style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;"><strong style=" color: #e86c3d;">{{ __('words.invite_location') }}:</strong>{{ $product->event->location }}</p>
            </div>
        </div>
        <div class="" style="text-align: center">
            <a href="{{ route('download.ticket', ['order' => $order, 'p' => $product->id, 't' => @$ticket?->ticket]) }}"
                class="btn-download text-white" style=" margin: 10% auto;
            padding: 13px 15px;
            background-color: #e86c3d;
            color: #d5d4d4;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            margin-top: 10px;">{{ __('words.download_invite_ticket') }}</a>
        </div>
        <div class="" style="text-align: center; margin-top: 40px;">
            <a href="{{ route('digital-wallet', ['user'=>$order->user,'event_id'=>$order->event_id]) }}"
                class="btn-download text-white" style=" margin: 10% auto;
            padding: 13px 15px;
            background-color: #e86c3d;
            color: #d5d4d4;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;">{{ __('words.wallet_link') }}</a>
        </div>
        <div class="email-footer" style="margin-top: 10px;
            padding: 15px;
            background-color: #ffffff;
            text-align: center;
            font-size: 14px;
            color: #040404;">
            <p style=" color: #5d5b5b;">{{ __('words.invite_footer_text') }} </p>
            <p style=" color: #5d5b5b;">{{ __('words.invite_footer_text2') }} </p>
        </div>
    </div>
</body>

</html>
