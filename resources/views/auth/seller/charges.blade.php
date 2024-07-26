@extends('layouts.seller-dashboar')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-dashboard-card space-bottom-30">
            <div class="ec-vendor-card-header">
                <h5>Subscription </h5>


            </div>

            @if ($charges->count() == !0)
                <div class="ec-vendor-card-body">

                    <div class="ec-vendor-card-table">



                        <table class="table ec-table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Account name</th>
                                    <th scope="col">Billing Reason</th>
                                    <th scope="col">Card</th>
                                   
                                    <th scope="col">Total</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($charges as $charge)
                                    <tr>
                                        <th scope="row"><span>{{ $charge->id }}</span></th>
                                        <td><span>{{ $charge->account_name }}</span></td>
                                        <td><span>{{ $charge->billing_reason }}</span></td>
                                        <td><span>{{ ucwords(auth()->user()->getCard()->card->brand) }} XXXX XXXX XXXX
                                                                {{ auth()->user()->getCard()->card->last4 }}</span></td>
                               
                                        <td><span>{{ Sohoj::price($charge->total / 100) }}</span></td>
                                        <td>
                                            <span><a href="{{ route('vendor.charge', $charge->id) }}"><i
                                                        class="fa-regular fa-eye"></i></a> </span>

                                        </td>

                                    </tr>
                                @endforeach


                            </tbody>
                        </table>

                    </div>

                </div>
            @else
                <h3 class="text-center text-danger">No Charges create</h3>
            @endif

                <h3 class="text-center">Cancelation</h3>
                        <div class="col-12 row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Cancel your Monthly Subscription</h6>
                                        <span>Your subscription won't be renewed if you cancel your Subscription.</span>

                                        <div class="d-flex justify-content-end">
                                            @if ($status == true)
                                            <a href="{{ route('vendor.cancelSubscription') }}" onclick="return confirm('Are you sure you want to cancel the subscription? Your subscription will be canceled after the billing cycle');" class="btn btn-warning">Cancel</a>
                                            @else
                                            <a href="{{ route('vendor.resumeSubscription') }}" onclick="return confirm('Do you want to resume your subscription?');" class="btn btn-warning">Resume</a>
                                            @endif
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Deactivate your Shop</h6>
                                        <span>Your Shop will be Deactivated. You won't be able to access any vendor
                                            feature.</span>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('vendor.cancelSubscriptionNow') }}" onclick="return confirm('Are you sure you want Deactived your shop?');" class="btn btn-danger bg-danger">Deactivate</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
        </div>
    </div>

@endsection
