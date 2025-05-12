<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <title>Your have a unpaid order | Email</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style type="text/css">
        body {
            font-family: "Montserrat", sans-serif;
            background-color: #cccbcb;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);
        }

        .email-header {
            text-align: center;
            padding: 20px 0;
        }

        .email-header img {
            max-width: 200px;
        }

        .email-ticket-boreder {
            border: 4px solid #e86c3d;
            width: 98.6%;
        }

        .email-content {
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #e86c3d;
        }

        p {
            text-align: center;
            font-size: 16px;
            line-height: 1.5;
            color: #454545;
        }

        strong {
            color: #e86c3d;
        }

        .btn-download {
            margin: 10% auto;
            padding: 13px 15px;
            background-color: #e86c3d;
            color: #ffffff;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            display: inline-block;
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
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ Voyager::image(setting('site.logo_black')) }}" alt="essenciacompany">
        </div>
        <div class="email-ticket-boreder"></div>
        <div class="email-content">
            {{ $slot }}
        </div>
        <div class="email-footer">
            <p style="color: #5d5b5b;">{{ __('words.footer_text') }} </p>
            <p style="color: #5d5b5b;">{{ __('words.footer_text2') }} </p>
        </div>
    </div>
</body>

</html>
