@extends('voyager::master')

@section('page_title', 'Bulk Invite')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-plus"></i>
            Bulk Invite
        </h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form action="{{ route('PersonalMassInvite') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="panel-body">

                            <div class="form-group  col-md-6">
                                <label class="control-label" for="name">Event</label>
                                <select name="event_name" id="eventSelect" class="form-control">
                                    <option value="">Select Event</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                                    @endforeach
                                </select>

                                <div id="productList" style="padding-top: 20px"></div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group ">
                                    <label class="control-label" for="file">Upload File <strong class="text-danger"
                                            style="font-size: 10px; font-weight: 600">(Excel)</strong></label>
                                    <input type="file" name="excel_file" id=""
                                        class="form-control @error('excel_file')
                                    is-invalid
                                @enderror">
                                    @error('excel_file')
                                        <span class="text-danger" style="font-size: 12px"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="extra_info">Extra info</label>
                                    <input type="text" name="extra_info" class="form-control">
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="send_message" type="checkbox" value="1"
                                        id="send_message">
                                    <label class="form-check-label" for="send_message">
                                        {{ __('words.send_message') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" name="send_email" type="checkbox" value="1"
                                        id="send_email">
                                    <label class="form-check-label" for="send_email">
                                        {{ __('words.send_email') }}
                                    </label>
                                </div>

                            </div>


                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary save">Save</button>
                        </div>
                    </form>

                    <div style="display:none">
                        <input type="hidden" id="upload_url" value="http://tickets-new.test/admin/upload">
                        <input type="hidden" id="upload_type_slug" value="invites">
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#eventSelect').on('change', function() {
                var eventId = $(this).val();

                if (eventId) {
                    $.ajax({
                        url: '{{ route('ajax.getProduct', ':eventId') }}'.replace(':eventId',
                            eventId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#productList').empty();

                            if (data.length > 0) {
                                $.each(data, function(key, product) {

                                    $('#productList').append(`
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_${product.id}">${product.name}</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input name="product[${product.id}][checked]" value="1" type="checkbox">
                                            </span>
                                            <input type="number" class="form-control" min="1" name="product[${product.id}][qty]" placeholder="${product.name}'s qty">
                                        </div>
                                    </div>
                                </div>
                            `);
                                });
                            } else {

                                $('#productList').append(
                                    '<div>No products available for this event.</div>');
                            }
                        },
                        error: function() {
                            $('#productList').html(
                                '<div>Error loading products. Please try again later.</div>'
                            );
                        }
                    });
                } else {
                    $('#productList').empty();
                }
            });
        });
    </script>
@stop
