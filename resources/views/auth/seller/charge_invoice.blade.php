@extends('layouts.seller-dashboar')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">

        <div class="container mt-5">
            <button class="btn btn-danger mb-3" onclick="printDiv('printableArea')">
                Print
            </button>
            <div class="row justify-content-center">
                <div class="" id="printableArea">
                    <div class="card">
                        <div class="card-header bg-dark">
                            <h3 class="card-title my-4" style="color:white">
                                {{ str_replace('_', ' ', $charge->billing_reason) }} Invoice</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Billing Details</h5>
                                    <p><strong>Customer Name:</strong> {{ auth()->user()->name }}</p>
                                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                    <p><strong>Address:</strong>
                                        {{ auth()->user()->shopAddress ? auth()->user()->shopAddress->address_1 : '' }},
                                        {{ auth()->user()->shopAddress ? auth()->user()->shopAddress->city : '' }}
                                        {{ auth()->user()->shopAddress ? auth()->user()->shopAddress->country : '' }}</p>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <h5 class="mb-3">Invoice Details</h5>
                                    <p><strong>Invoice Number:</strong> {{ $charge->id }}</p>
                                    <p>
                                    <strong>Card : </strong>{{ ucwords(auth()->user()->getCard()->card->brand) }} XXXX XXXX XXXX
                                                                {{ auth()->user()->getCard()->card->last4 }}
                                    </p>
                                    <p><strong>Date:</strong> {{ $charge->date()->toFormattedDateString() }}</p>
                                   
                                </div>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th>Description</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>{{ str_replace('_', ' ', $charge->billing_reason) }}</td>
                                            <td>{{ Sohoj::price($charge->amount_paid / 100) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Taxes</td>
                                            <td>{{ Sohoj::price($charge->tax) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td>{{ Sohoj::price($charge->total / 100) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>
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
@endsection
