@extends('voyager::master')
@php
    $edit = !is_null($dataTypeContent->getKey());
    $add = is_null($dataTypeContent->getKey());
    $events = App\Models\Event::all();
@endphp
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
                                @if ($edit)
                                    <input type="hidden" name="coupon_id" value="{{ $dataTypeContent->id }}">
                                @endif
                                <input type="hidden" name="quantity" value="1">
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Code</label>
                                        <input type="text" name="code"
                                            value="{{ old('code', $dataTypeContent->code) }}" id=""
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Discount</label>
                                        <input type="number" name="discount"
                                            value="{{ old('discount', $dataTypeContent->discount) }}" id=""
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Expire At</label>
                                        <input type="date" name="expire_at"
                                            value="{{ old('expire_at', $dataTypeContent->expire_at) }}" id=""
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Limit</label>
                                        <input type="number" value="{{ old('limit', $dataTypeContent->limit) }}"
                                            name="limit" id="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option @if ($dataTypeContent->type == 'percentage') selected @endif value="percentage">
                                                Percentage</option>
                                          
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="event_id">Events</label>

                                        <select name="event_id" id="event_id" class="form-control" required>
                                            @foreach ($events as $event)
                                                <option @if ($dataTypeContent->event_id == $event->id) selected @endif
                                                    value="{{ $event->id }}">{{ $event->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <label for="product_id">Products</label>
                                    <div id="productList"></div>

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
            var selectedProduct =@json( $edit ? $dataTypeContent->products()->get()->pluck('id')->toArray() :[]);

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
                                            <input type="checkbox" ${selectedProduct.includes(product.id) ? 'checked' : ''} name="product_id[]" value="${product.id}" id="product_${product.id}">
                                         
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
