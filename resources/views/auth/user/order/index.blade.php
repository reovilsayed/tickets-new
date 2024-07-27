@extends('layouts.user_dashboard')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12 mt-2">
        @foreach ($latest_orders as $order)
            <div class="card mb-3">
                {{-- <div class="card-header">
                    {{$order->status}}
                </div> --}}
                <div class="card-body">


                    @foreach ($order->products->groupBy('id') as $id => $products)
                        @php
                            $model = App\Models\Product::find($id);
                        @endphp
                        <h5 class="text-cus-secondary">
                            {{ $model->name }}
                        </h5>

                        <div class="row my-2">
                            <div class="col-12 col-md-6">


                                <p>
                                    Event : {{ $model->event_name }}
                                    <br>
                                    Host : {{ $model->event_host }}
                                    <br>
                                    Location : {{ $model->event_location }}
                                </p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p>
                                    Start At : {{ $model->event_start_date->format('d M, Y') }} <br>
                                    End At : {{ $model->event_end_date->format('d M, Y') }}
                                </p>

                            </div>

                        </div>
                        <br>
                        <table class="table">
                            <tr>
                                <th>
                                    #
                                </th>

                                <th>
                                    Ticket
                                </th>
                                <th>
                                    Cehck-In
                                </th>
                                <th>
                                    Check-Out
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Price
                                </th>


                            </tr>

                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $product->pivot->ticket }}
                                    </td>
                                    <td>
                                        {{ $product->pivot->check_in_at }}
                                    </td>
                                    <td>
                                        {{ $product->pivot->check_out_at }}

                                    </td>
                                    <td>
                                        {{ $product->pivot->status() }}

                                    </td>
                                    <td>
                                        {{ Sohoj::price($product->pivot->price) }}
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    @endforeach


                </div>
                <div class="card-footer bg-transparent p-2 ">
                    <table class="table table-striped ">
                        <tr>
                            <th style="font-size: 18px">
                                Subtotal 
                            </th>
                            <td style="font-size: 18px">
                                + {{ Sohoj::price($order->subtotal) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="font-size: 18px">
                                Tax 
                            </th>
                            <td style="font-size: 18px">
                                + {{ Sohoj::price($order->tax) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="font-size: 18px">
                                Discount 
                            </th>
                            <td style="font-size: 18px">
                                - {{ Sohoj::price($order->discount) }}
                            </td>
                        </tr>
                        <tr>
                            <th style="font-size: 25px">
                                Total
                            </th>
                            <td style="font-size: 25px">
                                = {{ Sohoj::price($order->total) }}
                            </td>
                        </tr>
                    </table>

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
