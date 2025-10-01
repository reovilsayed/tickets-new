<x-email>
    <style>
        /* Base Styles */
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



        .section {
            padding-bottom: 15px;
            border-bottom: 1px solid #eeeeee;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #3498db;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .info-item {
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            color: #555555;
        }

        .info-value {
            color: #333333;
        }

        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            grid-column: 1 / -1;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .items-table th {
            background-color: #f5f5f5;
            padding: 10px;
            border-bottom: 2px solid #dddddd;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eeeeee;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .highlight {
            color: #e74c3c;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            background-color: #3498db;
            color: white;
        }

        .address-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 15px;
        }

        .address-box {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }

        .address-title {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 16px;
        }

        /* Responsive Styles */
        @media only screen and (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .address-section {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .items-table {
                font-size: 12px;
            }

            .items-table th,
            .items-table td {
                padding: 8px 5px;
            }

            .email-body {
                padding: 15px;
            }
        }
    </style>

    <div class="email-body">

        <!-- Heading -->
        <h2 style="color:#2c3e50;">📚 Subscription Offer</h2>

        <!-- Basic Info -->
        <p style="font-size:15px; color:#333; margin:10px 0;">
            Hi {{ $order->user->name ?? 'Customer' }},
        </p>
        <p style="font-size:15px; color:#333; margin:10px 0;">
            We are excited to inform you that you have qualified for a special
            subscription magazine offer based on your purchase of the magazine
            <strong>{{ $order->magazine->name ?? 'N/A' }}</strong>.
        </p>

        <!-- Reward Message -->
        <div class="reward-box"
            style="background:#fdf5d4; border:1px solid #f1e1a6; padding:15px; border-radius:8px; margin-top:20px;">
            <h3 style="margin:0 0 10px 0; color:#c27c0e;">🎉 Special Reward</h3>
            <p style="margin:0; font-size:15px; color:#444;">
                Congratulations! You have received a <strong>reward subscription magazine offer</strong>.
                Stay tuned, more details will be shared with you soon.
            </p>
        </div>

    </div>
</x-email>
