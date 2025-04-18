<div>
    <h3 class="dashboard-title mb-3" style="color: #28BADF">
        {{ __('words.order_summary') }}
    </h3>

    <table class="table">
        <tr>
            <th>{{ __('words.name') }}</th>
            <th>{{ __('words.quantity') }}</th>
            <th>{{ __('words.price') }}</th>
            <th>{{ __('words.total') }}</th>
        </tr>

        @foreach ($cart->getContent() as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>X {{ $item->quantity }}</td>
                <td>{{ Sohoj::price($item->price) }}</td>
                <td>
                    {{ Sohoj::price($item->quantity * $item->price) }}

                </td>
            </tr>
        @endforeach
    </table>

    <div class="price-summary">
        <div class="price-row">
            <span>{{ __('words.subtotal') }}:</span>
            <span>{{ Sohoj::price($cart->getSubTotalWithoutConditions()) }}</span>
        </div>

        @if ($coupon)
            <div class="price-row text-danger">
                <span>{{ __('words.discount') }}
                    ({{ $coupon->getAttributes()['code'] }}):</span>
                <span>- {{ Sohoj::price($coupon->getCalculatedValue($cart->getSubTotal())) }}</span>
            </div>
        @endif


        @if ($shipping->count())
            <div class="price-row shipping-row">
                <span>{{ __('words.shipping') }}:</span>
                + {{ $shipping->sum(fn($d) => $d->getCalculatedValue($cart->getTotal())) }}
            </div>
        @endif



        <div class="price-row total-row">
            <span>{{ __('words.total') }}:</span>
            <span id="calculated-total">{{ Sohoj::price($cart->getTotal()) }}</span>
        </div>
    </div>


</div>
