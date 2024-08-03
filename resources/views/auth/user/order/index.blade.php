@extends('layouts.user_dashboard')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12 mt-2">
        <div class="card user-name">
            <div class="card-body">
                <span class="user-dash-font">Hello, {{ Auth::user()->name }}!</span>
            </div>
        </div>
        @foreach ($latest_orders as $order)
            <div class="ec-vendor-dashboard-card ec-vendor-setting-card mb-3">
                <div class="ec-vendor-card-body">


                    @foreach ($order->tickets->groupBy('product_id') as $id => $tickets)
                        @php
                            $model = App\Models\Product::find($id);
                        @endphp
                        <h4 class="dashboard-title mt-2 ">
                            {{ $model->name }}
                        </h4>
                        <small>
                            {{ $model->event->name }}
                        </small>
                        <br>
                        <div class="table-responsive">
                            <table class="order-table table mt-3">
                                <tr>
                                    <th>
                                        Ticket ID
                                    </th>
                                    <th>
                                        Payment Status
                                    </th>
                                    <th>
                                        Payment Type
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Price
                                    </th>


                                </tr>

                                @foreach ($tickets as $ticket)
                                    <tr>

                                        <td>
                                            {{ $ticket->ticket }}
                                        </td>
                                        <td>
                                            Paid
                                        </td>
                                        <td>
                                            Visa

                                        </td>
                                        <td>
                                            {{ $ticket->status() }}

                                        </td>
                                        <td>
                                            {{ Sohoj::price($ticket->price) }}
                                        </td>

                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endforeach


                </div>

                <div class="card-footer bg-transparent p-2 ">
                    <div class="row g-5">
                        <div class="col-md-6 col-12 d-flex align-items-center justify-content-center order-md-1 order-2 ">
                            <form action="{{ route('download.ticket') }}">

                                <input type="hidden" name="order" value="{{ $order->id }}">
                                <input type="hidden" name="product" value="{{ $id }}">
                                <button class="btn btn-primary btn-lg rounded ">
                                    <i class="fa fa-download"></i>
                                    Download
                                </button>
                            </form>
                          
                        </div>
                        <div class="col-md-6 col-12 order-md-2 order-1">
                            <div class="table-responsive">
                                <table class="payinfo table">
                                    <tr>
                                        <th style="font-size: 14px">
                                            Subtotal
                                        </th>
                                        <td style="font-size: 14px">
                                            + {{ Sohoj::price($order->subtotal) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 14px">
                                            Tax
                                        </th>
                                        <td style="font-size: 14px">
                                            + {{ Sohoj::price($order->tax) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 14px">
                                            Discount
                                        </th>
                                        <td style="font-size: 14px">
                                            - {{ Sohoj::price($order->discount) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 18px">
                                            Total
                                        </th>
                                        <td style="font-size: 18px">
                                            = {{ Sohoj::price($order->total) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        @endforeach
    </div>

    <!-- modal feedback start -->
    <div class="modal fade" id="feedback" tabindex="-1" aria-labelledby="feedback" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Give Feedback</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('user.feedback.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="">Feedback</label>
                                <textarea name="feedback" required class="form-control mb-2 @error('feedback') is-invalid @enderror" id="feedbackInput">
                            </textarea>
                                @error('feedback')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                                <input type="hidden" name="order_id" value="" id="order_id">
                            </div>


                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal end -->
@endsection
@section('js')
    <script>
        var exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget
            var recipient = button.getAttribute('data-bs-id')
            var modalBodyInput = exampleModal.querySelector('#orderId')

            modalBodyInput.value = recipient
        })
    </script>

    <script>
        $(document).ready(function() {
            $(".feedback-btn").click(function() {
                $('#order_id').val($(this).data('id'));
                var feedback = $('#feedbackInput').val($(this).data('feedback'));
                console.log(feedback);
                $('#addBookDialog').modal('show');
            });
        });
    </script>
@endsection
