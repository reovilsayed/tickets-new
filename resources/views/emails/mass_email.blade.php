<!DOCTYPE html>
<html>

<head>
    <title>{{ __('words.invite_email_subject') }}</title>
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

        .text-orange {
            color: #e86c3d !important;
        }

        .text-center {
            text-align: center;
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
                <h1>{{ __('words.invite_email-title') }}</h1>
                <h4 class="text-orange text-center">{{ __('words.invite_email-sub_title') }}:</h4>

                <p class="text-center" style="margin:0px;padding:0px;color:#5d5b5b"><strong>1<sup>o</sup></strong>
                    {{ __('words.invite_email-first_step') }} </p>
                <p class="text-center" style="margin:0px;padding:0px;color:#5d5b5b">
                    <strong>2<sup>o</sup></strong>{{ __('words.invite_email-second_step') }}
                </p>
                <p class="text-center" style="margin:0px;padding:0px;color:#5d5b5b"><strong>3<sup>o</sup></strong>
                    {{ __('words.invite_email-third_step') }} </p>
                <p class="text-center" style="margin:0px;padding:0px;color:#5d5b5b"><strong>4<sup>o</sup></strong>
                    {{ __('words.invite_email-fourth_step') }} </p>
                <p class="text-orange text-center">{{ __('words.invite_email-para') }}</p>
                <p><strong> {{ __('words.event') }}:</strong> {{ $invite->event->name }}</p>

            </div>
        </div>
        <div class="" style="text-align: center">
            <a href="{{ route('invite.product_details', ['invite' => $invite, 'security' => $invite->security_key]) }}"
                class="btn-download text-white">{{ __('words.invite_email-send_invite') }}</a>
        </div>
        <br>
        <br>
        <br>
    </div>
</body>

</html>
