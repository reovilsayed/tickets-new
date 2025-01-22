<!DOCTYPE html>
<html>

<head>
    <title>Event Tickets</title>

</head>

<body
    style='font-family: "Montserrat", sans-serif;
            background-color: #cccbcb;
            margin: 0;
            padding: 0;'>
    <div class="email-header" style="text-align: center;">
        <img src="{{ Voyager::image(setting('site.logo_black')) }}" alt="Essência Company" style="max-width: 200px;">
    </div>
    <div class="email-container"
        style="max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;">
        <div class="email-ticket-boreder" style="border: 4px solid #e86c3d;
            width: 98.6%"></div>
        <div class="email-content" style=" padding: 20px;">
            <div style="text-align: right">
                <h1 style=" text-align: center;
            color: #e86c3d;">{{ __('words.email_title') }}</h1>
                <p
                    style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;">
                    {{ __('words.thank_you_for_purchasing_tickets_to') }} </p>

                <p
                    style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;">
                    <strong style="color: #e86c3d;">{{ __('words.event_name') }}:</strong> {{ $product->event->name }}
                </p>
                <p
                    style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;">
                    <strong style="color: #e86c3d;">{{ __('words.ticket_name') }}:</strong> {{ $product->name }} </p>
                <p style="text-align: center"><strong style="color: #e86c3d;">{{ __('words.date') }}:</strong>
                    {{ $product->start_date->format('d M, Y h:i a') }} -
                    {{ $product->end_date->format('d M, Y h:i a') }}</p>
                <p
                    style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;">
                    <strong
                        style="color: #e86c3d;">{{ __('words.location') }}:</strong>{{ $product->event->location }}
                </p>
                @if ($product->event->website)
                    <p
                        style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;">
                        <strong
                            style="color: #e86c3d;">{{ __('words.website') }}:</strong>{{ $product->event->website }}
                    </p>
                @endif
            </div>
        </div>
        <div class="" style="text-align: center">
            <a href="{{ route('download.ticket', ['order' => $order, 'p' => $product->id, 't' => @$ticket?->ticket]) }}"
                class="btn-download text-white"
                style=" margin: 10% auto;
            padding: 13px 15px;
            background-color: #e86c3d;
            color: #d5d4d4;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            margin-top: 10px;">{{ __('words.download_ticket') }}</a>
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
        <div class="email-footer"
            style=" margin-top: 10px;
            padding: 15px;
            background-color: #ffffff;
            text-align: center;
            font-size: 14px;
            color: #040404;">
            <p style="color: #5d5b5b;">{{ __('words.footer_text') }} </p>
            <p style="color: #5d5b5b;">{{ __('words.footer_text2') }} </p>
        </div>
    </div>
</body>

</html>
