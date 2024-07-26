@extends('layouts.seller-dashboar')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">

        <div class="ec-vendor-dashboard-card ec-vendor-profile-card">
            <div class="ec-vendor-card-body">


                <div class="row">
                    <div class="col-md-12">
                        <div class="ec-vendor-block-profile">
                            <h4 class="mb-3">Shop Policy</h4>
                            <form class="  " action="{{ route('vendor.shopPolicy.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row ">



                                    <div class="col-md-12 mb-4">
                                        <div class="form-floating">
                                            <textarea class="form-control @error('delivery') is-invalid @enderror" id="floatingTextarea1" name="delivery"
                                                style="height: 100px">{{ auth()->user()->shop->shopPolicy ? auth()->user()->shop->shopPolicy->delivery : ' ' }}</textarea>
                                            <label for="floatingTextarea1">Delivery Policy</label>
                                            @error('delivery')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="form-floating">
                                            <textarea class="form-control @error('payment_option') is-invalid @enderror" id="floatingTextarea2"
                                                name="payment_option" style="height: 100px">{{ auth()->user()->shop->shopPolicy ? auth()->user()->shop->shopPolicy->payment_option : ' ' }}</textarea>
                                            <label for="floatingTextarea2">Payment Option</label>
                                            @error('payment_option')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="form-floating">
                                            <textarea class="form-control @error('return_exchange') is-invalid @enderror" id="floatingTextarea3" name="return_exchange"
                                                style="height: 100px">{{ auth()->user()->shop->shopPolicy ? auth()->user()->shop->shopPolicy->return_exchange : ' ' }}</textarea>
                                            <label for="floatingTextarea3">Return & Exchange Policy</label>
                                            @error('return_exchange')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <div class="form-floating">
                                            <textarea class="form-control @error('cancellation') is-invalid @enderror" id="floatingTextarea4" name="cancellation"
                                                style="height: 100px">{{ auth()->user()->shop->shopPolicy ? auth()->user()->shop->shopPolicy->cancellation : ' ' }}</textarea>
                                            <label for="floatingTextarea4">Cancellation Policy</label>
                                            @error('cancellation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                </div>

                                <button type="submit" class="btn btn-dark">Save</button>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
