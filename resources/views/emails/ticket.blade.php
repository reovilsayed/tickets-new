<!DOCTYPE html>
<html>
<head>
    <title>Event Tickets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
        }
        .email-header {
            background-color: #e8e8e8;
            padding: 20px;
            text-align: center;
        }
        .email-header img {
            max-width: 150px;
        }
        .email-content {
            padding: 20px;
        }
        .email-content h1 {
            color: #e86c3d;
        }
        .email-content p {
            font-size: 16px;
            line-height: 1.5;
        }
        .email-footer {
            margin-top: 20px;
            padding: 20px;
            background-color: #f7f7f7;
            text-align: center;
            font-size: 14px;
            color: #555555;
        }
        .btn-download {
            display: inline-block;
            padding: 10px 20px;
            background-color: #e86c3d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('path-to-your-logo/logo.png') }}" alt="Essência Company">
        </div>
        <div class="email-content">
            <h1>YOURS TICKETS</h1>
            <p>Thank you for purchasing tickets to <strong>{{ $eventName }}</strong>! We are thrilled to have you join us for this exciting event. Here are the details of your purchase:</p>
            <p><strong>Event:</strong> {{ $eventName }}</p>
            <p><strong>Date:</strong> {{ $eventDate }}</p>
            <p><strong>Time:</strong> {{ $eventTime }}</p>
            <p><strong>Location:</strong> {{ $eventVenue }}</p>
            <a href="{{ $downloadLink }}" class="btn-download">DOWNLOAD TICKETS</a>
            <p>Please keep this email as a confirmation of your purchase. Remember to bring a copy of your ticket or have it available on your mobile device for entry.</p>
        </div>
        <div class="email-footer">
            <p>If you have any questions or need further assistance, feel free to contact us at tickets@essenciacompany.com</p>
            <p>Best regards,</p>
            <p>Essência Company Team</p>
        </div>
    </div>
</body>
</html>
