@extends('layouts.seller-dashboard')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="row">
        </div>
        <div class="row mb-4">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-3">
                        <div class=" shadow bg-white p-2" style="border-radius: 12px;">
                            <div class="d-flex justify-content-between mb-4">
                                <i class="fa-solid fa-chart-pie dashboard-icon-btn pt-2"></i>
                                {{-- <div class="ec-select-inner dashboard-short-card-dropdown">
                                    <select  onchange="filterSecond(this.value,'sales')" class="p-0" name="ec-select" id="ec-select" style="font-weight: 600;">

                                        <option value="">Choose..</option>
                                        <option  {{ request('sales')==1 ? 'selected' : '' }} value="1">This Week</option>
                                        <option  {{ request('sales')==2 ? 'selected' : '' }} value="2">This Year</option>
                                        <option  {{ request('sales')==3 ? 'selected' : '' }} value="3">This Day</option>

                                    </select>
                                </div> --}}
                            </div>
                        <div>
                            <span class="" style="color:#8B8D97;font-size:14px; ">Sales</span>
                            <p style="color: #45464E;font-size: 20px;font-weight: 500;">{{ Sohoj::price($totalSell) }}</p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class=" shadow bg-white p-2" style="border-radius: 12px;">
                            <div class="d-flex justify-content-between mb-4">
                                <i class="fa-solid fa-user-group dashboard-icon-btn pt-2"></i>

                                {{-- <div class="ec-select-inner dashboard-short-card-dropdown">
                                    <select onchange="filterSecond(this.value,'customers')" class="p-0" name="ec-select" id="ec-select" style="font-weight: 600;">

                                        <option value="">Choose..</option>
                                        <option  {{ request('customers')==1 ? 'selected' : '' }} value="1">This Week</option>
                                        <option  {{ request('customers')==2 ? 'selected' : '' }} value="2">This Year</option>
                                        <option  {{ request('customers')==3 ? 'selected' : '' }} value="3">This Day</option>

                                    </select>
                                </div> --}}
                            </div>
                            <span class="" style="color:#8B8D97;font-size:14px; ">Customers</span>
                            <p style="color: #45464E;font-size: 20px;font-weight: 500;">{{ $customer->count() }}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class=" shadow bg-white  p-2" style="border-radius: 12px;">
                            <div class="d-flex justify-content-between mb-4">
                                <i class="fa-solid fa-bag-shopping dashboard-icon-btn pt-2"></i>


                                {{-- <div class="ec-select-inner dashboard-short-card-dropdown">
                                    <select onchange="filterSecond(this.value,'orders')" class="p-0" name="ec-select" id="ec-select" style="font-weight: 600;">
                                        <option value="">Choose..</option>
                                        <option {{ request('orders')==1 ? 'selected' : '' }} value="1">This Week</option>
                                        <option {{ request('orders')==2 ? 'selected' : '' }} value="2">This Year</option>
                                        <option {{ request('orders')==3 ? 'selected' : '' }} value="3">This Day</option>

                                    </select>
                                </div> --}}
                            </div>
                            <div class="row">
                                @php
                                    use App\Models\Order;
                                    $allOrders = Order::where('shop_id', auth()->user()->shop->id)
                                    ->countFilter()
                                    ->count('id');
                                    $pendingOrders = Order::where('status', 0)
                                        ->where('shop_id', auth()->user()->shop->id)
                                        ->countFilter()
                                        ->count('id');
                                    $completeOrders = Order::where('status', 4)
                                        ->where('shop_id', auth()->user()->shop->id)
                                        ->countFilter()
                                        ->count('id');
                                @endphp
                                <div class="col-4">
                                    <span class="" style="color:#8B8D97;font-size:14px; ">All Orders</span>
                                    <p style="color: #45464E;font-size: 20px;font-weight: 500;">{{ $allOrders }}</p>
                                </div>
                                <div class="col-4">
                                    <span class="" style="color:#8B8D97;font-size:14px; ">Pending</span>
                                    <p style="color: #45464E;font-size: 20px;font-weight: 500;">{{ $pendingOrders }}</p>
                                </div>
                                <div class="col-4">
                                    <span class="" style="color:#8B8D97;font-size:14px; ">Fulfill</span>
                                    <p style="color: #45464E;font-size: 20px;font-weight: 500;">{{ $completeOrders }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class=" shadow bg-white p-2 text-center" style="border-radius: 12px;">

                    <span class="" style="color:#8B8D97;font-size:14px; ">Inventory</span>
                    <p style="color: #45464E;font-size: 20px;font-weight: 500;margin-top: 16px">
                        {{ auth()->user()->shop->products->count() }}</p>
                    <span class="" style="color:#8B8D97;font-size:14px; ">Items</span>

                </div>
            </div>

        </div>
        <div class="row mb-4">
            <div class="col-md-12 ">
            <div class="container">
        <canvas id="ordersChart"></canvas>
    </div>
                <!-- <table class="table table-dark table-borderless ">
                    <thead>
                        <tr>

                            <th scope="col">
                                <div class="d-flex align-items-center">
                                    <span>Top 3 Items</span>
                                    <div class="ec-select-inner dashboard-short-card-dropdown bg-dark">
                                        <select class="p-0 bg-dark" name="ec-select" id="ec-select"
                                            style="font-weight: 600;">

                                            <option value="1">This Week</option>
                                            <option value="2">This Year</option>
                                            <option value="3">This Day</option>

                                        </select>
                                    </div>
                                </div>
                            </th>
                            <th scope="col">Total Sold</th>
                            <th scope="col">Total Earnings</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td>Toothbrush</td>
                            <td><span>50</span> <span class="text-success"><i class="fa-solid fa-caret-up"></i>12</span>
                            </td>
                            <td><span>$500.75</span> <span class="text-success"><i
                                        class="fa-solid fa-caret-up"></i>$1,294</span>
                            </td>
                        </tr>
                        <tr>

                            <td>Sunscreen</td>
                            <td><span>12</span> <span class="text-success"><i class="fa-solid fa-caret-up"></i>5</span>
                            </td>
                            <td><span>$125.00</span> <span class="text-success"><i
                                        class="fa-solid fa-caret-up"></i>$500</span>
                            </td>
                        </tr>
                        <tr>

                            <td>Water Bottle</td>
                            <td><span>9</span> <span class="text-danger"><i class="fa-solid fa-caret-down"></i>2</span>
                            </td>
                            <td><span>$50.75</span> <span class="text-success"><i
                                        class="fa-solid fa-caret-up"></i>$125</span>
                            </td>
                        </tr>
                    </tbody>
                </table> -->
            </div>
            {{-- <div class="col-md-5 border rounded-3 ">
                <div class="d-flex justify-content-between pt-3 border-bottom">
                    <h4>Offers</h4>
                    <a href="{{ route('vendor.offers') }}"><span>view<i class="ecicon eci-angle-double-right"
                                aria-hidden="true"></i></span></a>
                </div>
                <div class="scrollbar ">
                    @foreach ($offers as $offer)
                        <div class="row border-bottom ">
                            <div class="col-md-8 d-flex  align-items-center">
                                <img src="{{ Voyager::image($offer->product->image) }}" width="65" height="70"
                                    alt="">
                                <div class="p-1">
                                    <p>{{ $offer->user->name }}</p>
                                    <span>{{ $offer->product->name }}</span>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end"><span>{{ Sohoj::price($offer->price) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div> --}}
        </div>
        {{-- <div class="ec-vendor-dashboard-card space-bottom-30 shadow-sm" style="border-radius: 12px !important;">
            <div class="ec-vendor-card-header">
                <h5>Ticket Check</h5>
                <div class="d-flex align-items-baseline">
                    <form action="{{route('vendor.ticket.check')}}" method="post">
                        @csrf
                        <div class="row mt-2  me-1 justify-content-end">
                            <div class="form-group  col-md-12 d-flex">
                                <input type="text" name="ticket_search" class="" style=""
                                    placeholder="Check customer ticket">

                                <button type="submit" class="btn border btn-dark me-3"
                                    style="margin-right: 0 !important" id="basic-addon2"><span>Search</span></button>

                            </div>
                        </div>
                    </form>
                    <div class="ec-header-bt">
                        <a class="butn-dark2"
                            
                            href="{{ route('vendor.ordersIndex') }}"><i class="fi-rr-calendar-lines"></i><span>View
                                All</span> </a>
                    </div>

                </div>

            </div>
       
        </div> --}}

        <div class="ec-vendor-dashboard-card space-bottom-30 shadow-sm" style="border-radius: 12px !important;">
            {{-- <div class="ec-vendor-card-header">
                <h5>Inventory </h5>
                <div class="d-flex">
                    <div class="ec-header-btn">
                        <input class="form-control ec-search-bar" placeholder="Search products..." type="text">

                    </div>
                    <div class="ec-header-btn">
                        <a class="btn  btn-outline-dark" style="height: 47px;line-height: 48px; border:1px solid black"
                            href="#"><i class="fi-rr-filter"></i> Filter</a>
                    </div>


                </div>

            </div> --}}
            <x-products.index :products="$products" />
        </div>


    </div>
    <script>
        function filterSecond(e,peram) {
            var currentUrl = window.location.href;
            var url = new URL(currentUrl);

            url.searchParams.set(peram, e);
             console.log(e);

            //price
            var newUrl = url.href;
            window.location = newUrl;
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
        document.addEventListener('DOMContentLoaded', function() {
            var orders = @json($last15daysorders);

            // Process the orders data and format it as required by Chart.js
            var labels = orders.map(order => order.formatted_date);
            var data = orders.map(order => order.order_count);
           
            var ctx = document.getElementById('ordersChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Orders',
                        data: data,
                        backgroundColor: 'rgba(0, 123, 255, 0.5)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Order Quantity'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
