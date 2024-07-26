@extends('layouts.seller-dashboard')
@section('dashboard-content')
<style>
    /* Add your custom CSS styles here */
    /* For example: */


    .order-container {
        font-family: Arial, sans-serif;
        color: #333;
        max-width: 700px;
        height: auto;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .order-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .order-header h2 {
        font-size: 24px;
        margin: 0;
        color: #555;
    }

    .order-info {
        margin-bottom: 40px;
    }

    .order-info h4 {
        margin: 0 0 10px;
        color: #555;
    }

    .order-info p {
        margin: 0;
        color: #777;
    }

    .order-items {
        margin-bottom: 40px;
    }

    .order-items table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-items th,
    .order-items td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
        color: #555;
    }

    .order-items th {
        background-color: #f7f7f7;
    }

    .order-total {
        text-align: right;
        margin-bottom: 20px;
    }

    .total-amount {
        font-size: 20px;
        margin: 0;
        color: #555;
    }

    .order-actions {
        text-align: center;
        margin-bottom: 20px;
    }

    .button-group {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .action-button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #4a90e2;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .action-button:hover {
        background-color: #4281ca;
        color: #f7f7f7
    }

    .tracking-container {
        position: relative;
    }

    .add-tracking-button {
        padding: 13px 20px;
        font-size: 18px;
        background-color: #4a90e2;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .add-tracking-button:hover {
        background-color: #4281ca;
        color: #f7f7f7
    }

    .tracking-input {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        display: none;
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        z-index: 1;
        transition: opacity 0.3s ease-in-out;
    }

    .tracking-input.show {
        display: block;
    }

    .tracking-input input[type="text"],
    .tracking-input input[type="date"] {
        width: 300px;
        padding: 5px;
        border: 1px solid #ddd;
        font-size: 14px;
        color: #555;
    }

    .tracking-input button {
        padding: 5px 10px;
        font-size: 14px;
        background-color: #4a90e2;
        color: #fff;
        border: none;
        cursor: pointer;
        margin-top: 5px;
    }

    .tracking-input button:hover {
        background-color: #4281ca;
    }
</style>
<div class="order-container">
    <div class="order-header">
        <h2>Order Details</h2>
    </div>

    <div class="order-info">
        <h4>Order Information</h4>
        <p>Order ID: {{ $order->id }}</p>
        <p>Date: {{ $order->created_at->format('M d,Y') }}</p>
        {{-- <p>Customer: {{ $order->user->name }}</p> --}}
        {{-- <p>Customer Email: {{ $order->user->email }}</p> --}}
    </div>

    <div class="order-items">
        <h4>Order Items</h4>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              
                <tr>
                    <td>{{ $order->product->name }}</td>
                    {{-- <td>{{ $order->quantity }}</td> --}}
                    {{-- <td>
                        <p><span style="font-weight:800">Shipping method: {{$order->shipping_method}}</span></p>
                    </td> --}}
                    <td>
                        @if ($order->status == 1)
                        <span style="
                font-size: 13px;color: white;background-color: orange;padding: 0;margin-top: 15px;">Fulfill</span>
                         @elseif ($order->status == 2)
                         <span style="
                         font-size: 13px;color: white;background-color: red;padding: 0;margin-top: 15px;
                     ">Cancelled</span>
                        @else
                        <span style="
                font-size: 13px;color: white;background-color: indianred;padding: 0;margin-top: 15px;
            ">Pending</span>
                        @endif
                    </td>
                    <td>{{ Sohoj::price($order->price) }}</td>
                    <td>
                        <a href="{{route('vendor.ticket.update',$order)}}" onclick="return confirm('Are you sure you want to this ticket fullfill?');" class="butn-dark2"><span>Fulfill</span></a>
                    </td>
                </tr>

            </tbody>

        </table>
    </div>

    <div class="order-total">
        
       
    </div>

    {{-- <div class="order-actions">
        <div class="button-group">

            @if ($order->status == 0)
            <a href="{{ route('vendor.order.approve', ['order' => $order->id]) }}" class="action-button">Approve
                Order
            </a>
            @endif
            @if ($order->status !== 3 && $order->status !== 4)
            
            <a href="{{ route('vendor.order.cancel', ['order' => $order->id]) }}" class="action-button" style="background-color: grey">Cancel
                <i class="fa-solid fa-ban"></i></a>
            <div class="tracking-container">
                @if ($order->shipping_url == !null)
                @if($order->shipping_method=='DHL')
                <a class="add-tracking-button" target="_blank" href="https://nolp.dhl.de/nextt-online-public/set_identcodes.do?lang=de&idc={{$order->tracking_Id}}">Track Order </a>
                @endif
                @if($order->shipping_method=='Hermes')
                <a class="btn btn-sm btn-dark" target="_blank" href="https://www.myhermes.de/empfangen/sendungsverfolgung/suchen/sendungsinformation/{{$order->tracking_Id}}">Track Order</a>
                @endif
                @if($order->shipping_method=='DPD')
                <a class="add-tracking-button" target="_blank" href="https://tracking.dpd.de/parcelstatus?query={{$order->tracking_Id}}&locale=de_DE">Track Order</a>
                @endif

                @if($order->shipping_method=='UPS')
                <a class="add-tracking-button" target="_blank" href="http://wwwapps.ups.com/WebTracking/processInputRequest?sort_by=status&tracknums_displayed=1&TypeOfInquiryNumber=T&loc=de_DE&InquiryNumber1={{$order->tracking_Id}}&track.x=0&track.y=0">Track Order</a>
                @endif
                @if($order->shipping_method=='GLS')
                <a class="add-tracking-button" target="_blank" href="https://www.gls-pakete.de/sendungsverfolgung?match={{$order->tracking_Id}}&txtAction=71000">Track Order</a>
                @endif
                @if($order->shipping_method=='Fedex')
                <a class="add-tracking-button" target="_blank" href="https://www.fedex.com/fedextrack/?tracknumbers={{$order->tracking_Id}}&locale=de_DE&cntry_code=de">Track Order</a>
                @endif
                <!-- 
                @if($order->shipping_method=='Deutsche Post')
                <p>Tracking ID:<br> {{$order->tracking_Id}}</p>
                <a class="btn btn-sm btn-dark" target="_blank" href="https://www.deutschepost.de/sendung/simpleQuery.html"><i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Track Order</span> </a>
                @endif -->

                <!-- @if($order->shipping_method=='Anderes')
                <p>Versendet mit: "Anderes", kein Tracking möglich</p>
                @endif -->
                <!-- <a href="{{ $order->shipping_url }}" target="_blank" class="add-tracking-button" style="background-color: darkblue">Track Order</a> -->
                @endif
                <button class="action-button" onclick="toggleTrackingInput()" style="background-color: teal">Add
                    Tracking URL</button>
                <div id="trackingInputContainer" class="tracking-input">
                    <form action="{{ route('vendor.order.shipping') }}" method="post">
                        @csrf

                        <select class="from-control form-select border ms-0 mb-3" name="shipping_method" id="exampleFormControlSelect1">
                            @php
                            $partners = ['DHL', 'Hermes', 'DPD', 'UPS','GLS','Fedex'];
                            @endphp
                            @foreach ($partners as $partner)
                            <option value="{{ $partner }}" @if ($partner===$order->shipping_method) selected @endif>{{ $partner }}
                            </option>
                            @endforeach
                        </select>
                        <input id="orderId" type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="text" class="mb-3" id="trackingUrlInput" value="{{$order->shipping_url ? $order->shipping_url : ''}}" name="shipping_url" placeholder="Enter Tracking Id">

                        <input type="date" id="shipping_date" name="shipping_date" value="{{$order->shipping_date ? Carbon\Carbon::parse($order->shipping_date)->format('Y-m-d') :'' }}">
                        @error('shipping_date')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                        @enderror
                        <button type="submit">Save Tracking URL</button>
                    </form>
                </div>

            </div>


            <a href="{{ route('vendor.order.action', ['order' => $order->id]) }}" class=" action-button" style="background-color: orange">Deliver Order
            </a>
            @endif
        </div>
    </div> --}}


    <script>
        function toggleTrackingInput() {
            var trackingInputContainer = document.getElementById('trackingInputContainer');
            trackingInputContainer.classList.toggle('show');
        }

        function addTrackingUrl() {
            var trackingUrlInput = document.getElementById('trackingUrlInput');
            var trackingUrl = trackingUrlInput.value;

            // Perform any necessary action with the tracking URL, such as saving it to the database
            console.log('Tracking URL:', trackingUrl);

            // Clear the input field
            trackingUrlInput.value = '';

            // Hide the tracking input field
            toggleTrackingInput();
        }
    </script>
</div>
@endsection