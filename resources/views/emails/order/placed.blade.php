<x-email>

    <td class="review-name" style="margin-bottom: 20px; display: block;">
        <h5>Hello {{ $order->firstname }},</h5>
        
    </td>

    <td class="header-contain" style="margin-bottom: 20px; display: block;">
        <a class="cart-button" style="background-color:black; border:none;" href="{{ route('cart') }}">take me back to my
            cart</a>

    </td>

    <td style="margin-bottom: 20px; display: block;">
        <h4 style="margin: 0px 0px 5px;font-weight: 500;">Your Shopping Bag</h4>
        <table class="order-detail" border="0" cellpadding="0" cellspacing="0" align="left"
            style="width: 100%; margin-bottom: 20px;">
            <tr align="left">
                <th>Image</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>

            <tr>
                <td>
                    <img src="{{ Storage::url($order->product->image) }}" alt="" width="100">
                </td>

                <td align="top">
                    <h5 style="margin-top: 15px;">{{ $order->product->name }}
                    </h5>

                    {{-- <h5 style="font-size: 14px;color:#444;margin-top: 8px;margin-bottom: 0px;">
                        Size : <span>S</span>
                    </h5> --}}
                </td>
                <td align="top">
                    <h5 style="font-size: 14px; color:#444;margin-top: 15px;">{{ $order->quantity }}
                    </h5>
                </td>

                <td align="top">
                    <h5 style="font-size: 14px; color:#444;margin-top:15px">
                        <b>{{ Sohoj::price($order->Product->price) }}</b>
                    </h5>
                </td>
            </tr>





            <tr class="pad-left-right-space ">
                <td class="m-b-5" colspan="2" align="left">
                    <h6 style="font-weight: 400;font-size: 14px; margin: 0;">Grand Total :</h6>
                </td>

                <td class="m-b-5" colspan="2" align="right">
                    <h6 style="font-weight: 500;font-size: 14px; margin: 0;">{{ Sohoj::price($order->total) }}</h6>
                </td>
            </tr>
        </table>
    </td>

    <td class="header-contain" style="margin: 20px 0; display: block;">

        <a class="cart-button" style="background-color:black;border:none;" href="{{ route('thankyou') }}">complete
            checkout</a>
    </td>

</x-email>
