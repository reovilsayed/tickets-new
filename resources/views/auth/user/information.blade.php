@extends('layouts.user_dashboard')

@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
            <div class="ec-vendor-card-body">
                <form action="{{ route('user.address.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">




                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="country">
                                    Country
                                </label>
                                <input id="country" type="text" name="country"
                                    class="form-control @error('country') is-invalid @enderror"
                                    value="{{ $address->country }}">
                                @error('country')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="city">
                                    City
                                </label>
                                <input id="city" type="text" name="city"
                                    class="form-control @error('city') is-invalid @enderror" value="{{ $address->city }}">
                                @error('city')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="state">
                                    State
                                </label>
                                <input id="state" type="text" name="state"
                                    class="form-control @error('state') is-invalid @enderror" value="{{ $address->state }}">
                                @error('state')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="post_code">
                                    Post code
                                </label>
                                <input id="post_code" type="text" name="post_code"
                                    class="form-control @error('post_code') is-invalid @enderror" value="{{ $address->post_code }}">
                                @error('post_code')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="address">
                                    Permanent address
                                </label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address_1" id="address">{{ $address->address_1 }}</textarea>
                                @error('address')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="home_address">
                                    Home address
                                </label>
                                <textarea class="form-control @error('home_address') is-invalid @enderror" name="address_2" id="home_address">{{ $address->address_2 }}</textarea>
                                @error('home_address')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-lg btn-dark mt-2 rounded">Update</button>

                </form>
            </div>

        </div>
    </div>
@endsection
