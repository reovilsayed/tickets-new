@extends('voyager::master')

@section('page_title', 'Invoice #' . $order->id)

@section('css')
    <style>
        .pill {
            border-radius: 8px;
            padding: 4px 10px;
        }

        .pill-success {
            color: #05ca26;
            background-color: rgba(172, 255, 47, 0.3);
        }

        .pill-danger {
            color: #a00000;
            background-color: rgba(251, 1, 1, 0.3);
        }

        .pill-secondary {
            color: #3b3b3b;
            background-color: rgba(27, 27, 27, 0.3);
        }

        .panel {
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 8px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="panel">
            <button onclick="window.print()" class="btn btn-primary">Print</button>
            <h1>Invoice #{{ $order->invoice_id ?? $order->id }}</h1>
            <span class="pill pill-{{ $order->status == 'active' ? 'success' : 'danger' }}">
                {{ ucfirst($order->status) }}
            </span>
            {{-- <p>Created On: {{ $order->created_at->format('d F, Y') }}</p>
            <p>Updated On: {{ $order->updated_at->format('d F, Y') }}</p> --}}
        </div>

        <div class="row">
            <!-- User Info -->
            <div class="col-md-6">
                <div class="panel">
                    <h3>User Information</h3>
                    <hr>
                    <p><strong>Name:</strong> {{ $order->user->name ?? $order->billing->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email ?? $order->billing->email }}</p>
                    <p><strong>Address:</strong> {{ $order->user->address ?? $order->billing->address }}</p>
                    <p><strong>VAT Number:</strong> {{ $order->user->vatNumber ?? ($order->billing->vatNumber ?? 'N/A') }}
                    </p>
                </div>
            </div>

            <!-- Order Info -->
            <div class="col-md-6">
                <div class="panel">
                    <h3>Order Information</h3>
                    <hr>
                    <p><strong>Magazine:</strong> {{ $order->magazine->title ?? 'N/A' }}</p>
                    <p><strong>Subscription Type:</strong> {{ ucfirst($order->subscription_type) }}</p>
                    <p><strong>Recurring Period:</strong> {{ $order->recurring_period }} months</p>
                    <p><strong>Start Date:</strong> {{ $order->start_date?->format('d F, Y') ?? 'N/A' }}</p>
                    <p><strong>End Date:</strong> {{ $order->end_date?->format('d F, Y') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="panel">
            <h3>Payment Details</h3>
            <hr>
            <div class="row">
                <table class="table table-bordered">
                    <tr>
                        <th>Total</th>
                        <td>{{ number_format($order->total, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Payment Status</th>
                        <td>
                            <span class="pill pill-{{ $order->payment_status ? 'success' : 'danger' }}">
                                {{ $order->payment_status ? 'Paid' : 'Not Paid' }}
                            </span>
                        </td>
                    </tr>
                </table>

                @if ($order->shipping_info)
                    @php $shipping = json_decode($order->shipping_info, true); @endphp
                    <div class="col-md-6">
                        <h3>Shipping Information</h3>
                        <hr>
                        <p><strong>Recipient:</strong> {{ $shipping['recipient_name'] ?? '' }}</p>
                        <p><strong>Company:</strong> {{ $shipping['company'] ?? '' }}</p>
                        <p><strong>Street:</strong> {{ $shipping['street_address'] ?? '' }}
                            {{ $shipping['apartment'] ?? '' }}
                        </p>
                        <p><strong>City:</strong> {{ $shipping['city'] ?? '' }}</p>
                        <p><strong>State:</strong> {{ $shipping['state_province'] ?? '' }}</p>
                        <p><strong>Postal Code:</strong> {{ $shipping['postal_code'] ?? '' }}</p>
                        <p><strong>Phone:</strong> {{ $shipping['phone'] ?? '' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
