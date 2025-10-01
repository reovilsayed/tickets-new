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
    
    <!-- Body -->
    <div class="email-body">
        <!-- Greeting -->
        <div class="section">
            <h2>Hello {{ $order->user->name }},</h2>
            <p>Thank you for your magazine order! We're preparing your items for shipment. Here are your order details:</p>
            <p><span class="status-badge">Order #{{ $order->id }}</span></p>
        </div>

        <!-- Order Summary -->
        <div class="section">
            <div class="section-title">Order Summary</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Order ID:</span>
                    <span class="info-value">#{{ $order->id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Transaction ID:</span>
                    <span class="info-value">{{ $order->transaction_id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Subscription Type:</span>
                    <span class="info-value">{{ ucfirst($order->type) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Currency:</span>
                    <span class="info-value">{{ $order->currency }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Order Date:</span>
                    <span class="info-value">{{ $order->created_at->format('M j, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Ordered Items -->
        <div class="section">
            <div class="section-title">Ordered Items</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Magazine</th>
                        <th>Archive</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        @php
                            $itemTotal = $item->quantity * $item->price;
                        @endphp
                        <tr>
                            <td>{{ $item->itemable->magazine->name ?? ($order->magazine->name ?? 'N/A') }}</td>
                            <td>{{ $item->itemable->title ?? 'N/A' }}</td>
                            <td>{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Financial Summary -->
        <div class="section">
            <div class="section-title">Financial Summary</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Subtotal:</span>
                    <span class="info-value">{{ $order->currency }} {{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Discount:</span>
                    <span class="info-value">{{ $order->currency }} {{ number_format($order->discount ?? 0, 2) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Shipping Cost:</span>
                    <span class="info-value">{{ $order->currency }} {{ number_format($order->shipping, 2) }}</span>
                </div>
                <div class="info-item total-row">
                    <span class="info-label">Total Amount:</span>
                    <span class="info-value highlight">{{ $order->currency }} {{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Billing & Shipping Information in One Row -->
        <div class="section">
            <div class="section-title">Billing & Shipping Information</div>
            <div class="address-section">
                <!-- Billing Information -->
                @if($order->billing)
                <div class="address-box">
                    <div class="address-title">Billing Address</div>
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <span class="info-value">{{ $order->billing->name ?? '' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">VAT:</span>
                        <span class="info-value">{{ $order->billing->vatNumber ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Address:</span>
                        <span class="info-value">{{ $order->billing->address ?? '' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $order->billing->phone ?? '' }}</span>
                    </div>
                </div>
                @endif

                <!-- Shipping Information -->
                @php
                    $shipping = json_decode($order->shipping_info, true);
                @endphp
                <div class="address-box">
                    <div class="address-title">Shipping Address</div>
                    <div class="info-item">
                        <span class="info-label">Recipient:</span>
                        <span class="info-value">{{ $shipping['recipient_name'] ?? '' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Company:</span>
                        <span class="info-value">{{ $shipping['company'] ?? 'N/A' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Address:</span>
                        <span class="info-value">
                            {{ $shipping['street_address'] ?? '' }}{{ $shipping['apartment'] ? ', ' . $shipping['apartment'] : '' }}<br>
                            {{ $shipping['city'] ?? '' }}, {{ $shipping['state_province'] ?? '' }} {{ $shipping['postal_code'] ?? '' }}<br>
                            {{ $shipping['country'] ?? '' }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $shipping['phone'] ?? '' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $shipping['email'] ?? '' }}</span>
                    </div>
                    @if(!empty($shipping['special_instructions']))
                    <div class="info-item">
                        <span class="info-label">Instructions:</span>
                        <span class="info-value">{{ $shipping['special_instructions'] }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-email>