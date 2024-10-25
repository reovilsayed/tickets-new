@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop



@section('content')
    <div class="container">
        <div class="page-content edit-add">
            <h3>
                Personal invite for {{ $product->event->name }} - {{ $product->name }}
            </h3>
            <div class="panel">
                <div class="panel-body">
                    <form action="{{ route('voyager.products.invite.post', $product) }}" method="post">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone">
                                    <small>
                                        Phone is required if you want to send message
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input type="number" min="1" max="{{ $product->quantity }}" class="form-control"
                                        id="qty" name="qty">
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="send_message">
                                    <input class="form-check-input" type="checkbox" name="send_message" value="1"
                                        id="flexCheckChecked">
                                    <label class="form-check-label" for="send_message">
                                        Send message
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary"><i class="voyager-paper-plane"></i> Send Invite</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- End Delete File Modal -->
@stop
