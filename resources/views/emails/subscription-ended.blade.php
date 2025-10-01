<x-email>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333333;
            background-color: #f7f7f7;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .highlight {
            color: #e74c3c;
            font-weight: bold;
        }

        .btn-primary {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 20px;
            background-color: #3498db;
            color: #fff !important;
            font-size: 15px;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
        }

        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 15px;
            }
        }
    </style>

    <div class="email-body">

        <!-- Heading -->
        <h2 style="color:#2c3e50;">⚠️ Subscription Ended</h2>

        <!-- Basic Info -->
        <p style="font-size:15px; color:#333; margin:10px 0;">
            Hi {{ $order->user->name ?? 'Customer' }},
        </p>

        <p style="font-size:15px; color:#333; margin:10px 0;">
            Your subscription for the magazine <strong>{{ $order->magazine->name ?? 'N/A' }}</strong> 
            has <span class="highlight">ended after 1 year</span>.
        </p>

        <!-- Renewal Message -->
        <p style="font-size:15px; color:#333; margin:15px 0;">
            If you wish to continue enjoying our magazines, please renew your subscription today.
        </p>

        <a href="{{ url('/subscriptions/renew') }}" class="btn-primary">🔄 Renew Subscription</a>

    </div>
</x-email>
