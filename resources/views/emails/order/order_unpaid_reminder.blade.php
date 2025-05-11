<x-email>
    <td style="margin-bottom: 30px; display: block; padding: 0 20px;">
        <div style="text-align: left; margin-bottom: 25px;">
            <h5 style="margin: 0 0 15px 0; font-size: 18px; color: #333; font-weight: 600;">Hello {{ $order->user->name }},</h5>
            <p style="margin: 10px 0; font-size: 15px; line-height: 1.6; color: #555;">
                We noticed you haven't completed your order from {{ $order->created_at->diffForHumans() }}.
            </p>
            <p style="margin: 10px 0; font-size: 15px; line-height: 1.6; color: #555;">
                Your cart items are being held for you, but they may be released soon.
            </p>
        </div>

        <div style="margin-bottom: 30px;">
            <h4 style="margin: 0 0 15px 0; font-size: 18px; color: #e86c3d; font-weight: 600; text-align: left;">Your Pending Order</h4>
            <table class="order-detail" border="0" cellpadding="0" cellspacing="0" width="100%" 
                   style="width: 100%; margin-bottom: 20px; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f8f8;">
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #333; border-bottom: 2px solid #e86c3d;">Item</th>
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #333; border-bottom: 2px solid #e86c3d;">Qty</th>
                        <th style="padding: 12px 15px; text-align: left; font-weight: 600; color: #333; border-bottom: 2px solid #e86c3d;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items() as $item)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px; text-align: left; vertical-align: top;">
                            <h5 style="margin: 0; font-size: 15px; color: #333; font-weight: 500;">{{ $item['name'] }}</h5>
                        </td>
                        <td style="padding: 15px; text-align: left; vertical-align: top;">
                            <h5 style="margin: 0; font-size: 15px; color: #666;">{{ $item['qty'] }}</h5>
                        </td>
                        <td style="padding: 15px; text-align: left; vertical-align: top;">
                            <h5 style="margin: 0; font-size: 15px; color: #333; font-weight: 600;">
                                {{ Sohoj::price($item['total']) }}
                            </h5>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="padding: 15px; text-align: left; border-top: 2px solid #eee;">
                            <h6 style="margin: 0; font-size: 15px; font-weight: 600; color: #333;">Grand Total:</h6>
                        </td>
                        <td style="padding: 15px; text-align: left; border-top: 2px solid #eee;">
                            <h6 style="margin: 0; font-size: 16px; font-weight: 700; color: #e86c3d;">{{ Sohoj::price($order->total) }}</h6>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div style="text-align: center; margin: 30px 0; padding: 0 20px;">
            <p style="color: #e86c3d; font-weight: 600; font-size: 16px; margin-bottom: 20px;">
                This order will expire soon!
            </p>
            @if ($order->payment_link)
                <a href="{{ $order->payment_link }}" 
                   style="display: inline-block; background-color: #e86c3d; color: white; 
                          padding: 12px 30px; text-decoration: none; border-radius: 30px; 
                          font-weight: 600; font-size: 15px; transition: all 0.3s ease;">
                    Complete Your Payment Now
                </a>
            @endif
        </div>
    </td>
</x-email>