@extends('layouts.user_dashboard')
@section('dashboard-content')
<div class="ec-shop-rightside col-lg-9 col-md-12 mt-2">
    <div class="ec-vendor-dashboard-card space-bottom-30 shadow-sm" style="border-radius: 10px !important;">
        <div class="container">
 

            @if ($latest_orders->count() > 0)
            <div class="col-md-12">
                @foreach ($latest_orders as $order)
                <div class="container title-margin mt-2 bg-dark border rounded-5">

                    <div class="container-fluid title-margin p-2 d-flex justify-content-between align-items-center ">
                       
                        @if ($order->status == 0)
                        <h4 class="text-white">Pending Orders</h4>
                        @endif
                        @if ($order->status == 2)
                        <h4 class="text-white">Fullfill</h4>
                        @endif
                        @if ($order->status == 3)
                        <h4 class="text-white">Canceled</h4>
                        @endif



                        <p class="text-white">Order date: {{ $order->created_at->format('M-d-Y') }}</p>
                    </div>
                </div>

                <div class="col-md-12 mb-2">
                    <div class="cart-item card rounded-4">
                        <div class="card-body row box-shadow d-flex justify-content-between align-items-center">

                            <div class="col-md-8 row">
                                <div class="col-md-5 center">
                                    <img class="cart-item-image" src="{{ Storage::url($order->product->image) }}" alt="">
                                </div>
                                <div class="col-md-6  cart-item-text">
                                    <a href="{{route('user.invoice',$order)}}">

                                        <h4 class="font-size">{{ $order->product->name }}</h4>
                                    </a>
                                    <p class="item-title">
                                        {{ Str::limit(strip_tags($order->product->short_description), $limit = 150, $end = '...') }}
                                    </p>
                                   
                                    <strong class="text-dark"><span>Price:</span>
                                        <span style="text-decoration: line-through;">{{ Sohoj::price($order->Product->price) }}</span>
                                        <span>{{ Sohoj::price($order->total) }}</span></strong>
                                    @if ($order->status == 0)
                                    <a href="{{$order->parent->payment_method}}" class="btn btn-sm mt-2 btn-primary rounded">Procced to payment</a>
                            
                                    @endif
                              

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="ec-sidebar-block  side-bar-box ">

                                    <div class="ec-sb-block-content">
                                        @if ($order->status == 1)
                                        <div class=" p-2 border rounded-3 d-flex justify-content-center">

                                            {!! QrCode::size(150)->generate($order->order_number) !!}
                                        </div>
                                        @endif



                                    </div>
                                </div>

                            </div>
                        </div>



                    </div>
                </div>
                @endforeach

            </div>
            @else
            <h3 class="text-center text-dark">No order has been placed</h3>
            @endif
        </div>
    </div>
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
                            <input type="hidden" name="order_id"  value="" id="order_id">
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
    $(document).ready(function () {
    $(".feedback-btn").click(function () {
        $('#order_id').val($(this).data('id'));
       var feedback= $('#feedbackInput').val($(this).data('feedback'));
       console.log(feedback);
        $('#addBookDialog').modal('show');
    });
});
</script>
@endsection