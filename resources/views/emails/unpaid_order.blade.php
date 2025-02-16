@component('mail::message')
# Payment Reminder

Hello,

We noticed that your order **#{{ $order->id }}** is still unpaid. Please complete the payment as soon as possible.

@component('mail::button', ['url' => route('homepage')])
Pay Now
@endcomponent

Thank you!
{{ config('app.name') }}
@endcomponent
