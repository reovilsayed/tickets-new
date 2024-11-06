<!DOCTYPE html>
<html>

<head>
    <title>{{ __('words.invite_email_subject') }}</title>
    <style>
       

       

       



        

       

    </style>
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
        style=" max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;">
        <div class="email-ticket-boreder" style="border: 4px solid #e86c3d;
            width: 98.6%"></div>
        <div class="email-content" style="padding: 20px;">
            <div style="text-align: right">
                <h1 style=" text-align: center;
            color: #e86c3d;">{{ __('words.invite_email-title') }}</h1>
                <h4 class="text-orange text-center" style="color: #e86c3d !important;text-align: center;">{{ __('words.invite_email-sub_title') }}:</h4>

                <p class="text-center" style="margin:0px;padding:0px;color:#5d5b5b;text-align: center;" style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;"><strong>1<sup>o</sup></strong>
                    {{ __('words.invite_email-first_step') }} </p>
                <p class="text-center" style="margin:0px;padding:0px;color:#5d5b5b ; text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;" >
                    <strong>2<sup>o</sup></strong>{{ __('words.invite_email-second_step') }}
                </p>
                <p class="text-center" style="margin:0px;padding:0px;color:#5d5b5b ; text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;"><strong>3<sup>o</sup></strong>
                    {{ __('words.invite_email-third_step') }} </p>
                <p class="text-center" style="margin:0px;padding:0px;color:#5d5b5b ; text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;"><strong>4<sup>o</sup></strong>
                    {{ __('words.invite_email-fourth_step') }} </p>
                <p class="text-orange text-center" style=" text-align: center; color: #e86c3d !important;;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;">{{ __('words.invite_email-para') }}</p>
                <p style=" text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;"><strong> {{ __('words.event') }}:</strong> {{ $invite->event->name }}</p>

            </div>
        </div>
        <div class="" style="text-align: center">
            <a href="{{ route('invite.product_details', ['invite' => $invite, 'security' => $invite->security_key]) }}"
                class="btn-download text-white" style="margin: 10% auto;
            padding: 13px 15px;
            background-color: #e86c3d;
            color: #d5d4d4;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            margin-top: 10px;">{{ __('words.invite_email-send_invite') }}</a>
        </div>
        <br>
        <br>
        <br>
    </div>
</body>

</html>
