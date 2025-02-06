@extends('voyager::master')

@section('page_title', ' Customer')
@section('css')
    <style>
        .coupon-header-titile {
            color: rgba(65, 62, 62, 0.804);
            font-weight: 700;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="">
            <h3 class="coupon-header-titile">
                Coupons Generate
            </h3>
        </div>
        <div class="panel">
            <div class="panel-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('voyager.coupon.create') }}" method="POST">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Quantity</label>
                                        <input type="number" name="quantity" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Discount</label>
                                        <input type="number" name="discount" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Expire At</label>
                                        <input type="date" name="expire_at" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Limit</label>
                                        <input type="number" name="limit" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="percentage">Percentage</option>
                                            <option value="fixed">Fixed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="event_id">Events</label>
                                        <select name="event_id" id="event_id" class="form-control" required>
                                            @foreach ($events as $event)
                                                <option value="{{ $event->id }}">{{ $event->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <label for="product_id">Products</label>
                                    <div id="productList"></div>

                                </div>

                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">
                                Proccess
                            </button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        function fetchEvent() {
            var eventId = $('#event_id').val();

            if (eventId) {
                $.ajax({
                    url: '{{ route('get.products', ':eventId') }}'.replace(':eventId',
                        eventId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#productList').empty();

                        if (data.length > 0) {
                            $.each(data, function(key, product) {

                                $('#productList').append(`
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="product_id[]" value="${product.id}" id="product_${product.id}">
                                            ${product.name}
                                        </label>
                                    </div>

        `);
                            });
                        } else {
                            $('#productList').html(
                                '<p>No product available</p> '
                            );
                        }
                    },
                    error: function() {
                        $('#productList').html(
                            '<p>No product available</p> '
                        );
                    }
                });
            } else {
                $('#productList').empty();
            }
        }
        $(document).ready(function() {
            $('#event_id').on('change', function() {
                fetchEvent();
            });
            fetchEvent();
        });
    </script>
@stop
