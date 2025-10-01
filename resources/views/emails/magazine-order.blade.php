<!DOCTYPE html>
<html>

<head>
    <title>Magazine Order Details</title>
</head>

<body>
    <h2>Hello {{ $order->user->name ?? $order->billing->name }},</h2>

    <p>Here are the details of your magazine order #{{ $order->id }}:</p>

    <ul>
        <li>Magazine: {{ $order->magazine->title ?? 'N/A' }}</li>
        <li>Subscription Type: {{ $order->subscription_type ?? 'N/A' }}</li>
        <li>Recurring Period: {{ $order->recurring_period ?? 'N/A' }} months</li>
        <li>Status: {{ $order->status ? 'Active' : 'Inactive' }}</li>
        <li>Total: {{ $order->total ?? 'N/A' }}</li>
        <li>Start Date: {{ $order->start_date?->format('d F, Y') ?? 'N/A' }}</li>
        <li>End Date: {{ $order->end_date?->format('d F, Y') ?? 'N/A' }}</li>
    </ul>

    <p>Thank you for your subscription!</p>
</body>

</html>
