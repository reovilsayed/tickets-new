<div class="d-flex justify-content-end mb-2">
    {{-- <button onclick="printDiv('printableArea')" class="btn btn-dark ">Print this page</button> --}}
</div>

<div id="printableArea">
    <div class="invoice-container">
        <div class="logo">
            <img src="{{ Voyager::image($order->shop->logo) }}" alt="Logo">
        </div>

        <div class="invoice-header">
            <h2>Order Invoice</h2>
        </div>

        <div class="invoice-info row">
            <div class="shop-info col-md-6">
                <h4>Shop Information</h4>
                <p>{{ $order->shop->name }}</p>
                <p>{{ $order->shop->post_code }}, {{ $order->shop->city }}<br>
                    {{ $order->shop->state }} ({{ $order->shop->country }})</p>
                <p>Phone: {{ $order->shop->phone }}</p>
            </div>
            <div class="customer-info col-md-6">
                <h4>Customer Information</h4>
               
                <p> <span style="font-weight: 800;">Invoice No:</span> {{ $order->id }}</p>
                <p>{{ $order->created_at->format('M-d-Y') }}</p>
                <p> <span style="font-weight: 800;"> Name: </span> {{ $order->first_name }} {{ $order->last_name }}</p>
                <!-- <p>Phone: {{$order->phone}}</p> -->
    

                    <p class=""> <span style="font-weight: 800;"> Address: </span> {{$order->city}},{{ $order->state }},{{$order->postCode}}</p>
               
            </div>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Description</th>
                    {{-- <th>Quantity</th> --}}
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
              
                    <tr>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ strip_tags($order->product->short_description) }}</td>
                        {{-- <td>{{ $order->quantity }}</td> --}}
                        <td>{{ Sohoj::price($order->price) }}</td>
                    </tr>
                
            </tbody>
            <tfoot>

                <tr>
                    <td colspan="2">Total</td>
                    <td>{{ Sohoj::price($order->price) }}</td>
                </tr>
            </tfoot>
        </table>

        {{-- <div class="invoice-total">
            <p class="total-amount">Total Amount: {{ Sohoj::price($order->vendor_total) }}</p>
        </div> --}}

        <div class="thank-you">
            <p>Thank you for your business!</p>
        </div>
    </div>
</div>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
