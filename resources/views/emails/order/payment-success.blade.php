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

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #3498db;
        }

        .highlight {
            color: #27ae60;
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
        <h2 style="color:#2c3e50;">✅ Payment Successful</h2>

        <!-- Basic Info -->
        <p style="font-size:15px; color:#333; margin:10px 0;">
            Hi {{ $order->user->name ?? 'Customer' }},
        </p>

        <p style="font-size:15px; color:#333; margin:10px 0;">
            Your payment for the magazine <strong>{{ $order->magazine->name ?? 'N/A' }}</strong>
            has been <span class="highlight">successfully completed</span>.
        </p>

        <!-- Dashboard Button -->
        <p style="font-size:15px; color:#333; margin:15px 0;">
            You can now go to your dashboard and start reading your magazine.
        </p>

        <a href="{{ url('/dashboard/magazines') }}" class="btn-primary">📖 Go to Dashboard</a>

    </div>
</x-email>
