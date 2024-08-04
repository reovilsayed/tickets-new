@extends('layouts.user_dashboard')

@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="card user-name">
            <div class="card-body">
                <span class="user-dash-font">Hello, {{ Auth::user()->name }}!</span>
            </div>
        </div>
        <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
            <div class="ec-vendor-card-body">
                <h4 class="dashboard-title mb-5">
                    Update profile
                </h4>
                <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">
                                    First name
                                </label>
                                <input id="first_name" type="text" name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ Auth::user()->name }}">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label for="last_name">
                                    Last name
                                </label>
                                <input id="last_name" type="text" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ Auth::user()->l_name }}">
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="email">
                                    Email
                                </label>
                                <input class="form-control @error('email') is-invalid @enderror" name="email"
                                    id="email" disabled value="{{ Auth::user()->email }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="contact_number">
                                    Contact number
                                </label>
                                <input class="form-control  @error('meta') is-invalid @enderror" name="contact_number"
                                    id="contact_number" value="{{ Auth::user()->contact_number }}">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="vatNumber">Taxpayer</label>
                                <input type="text" class="form-control" name="vatNumber" value="{{auth()->user()->vatNumber}}">
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" value="{{auth()->user()->address}}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary mt-5 rounded">Update</button>

                </form>
            </div>

        </div>
    </div>
@endsection
