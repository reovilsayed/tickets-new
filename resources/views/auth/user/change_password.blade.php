@extends('layouts.user_dashboard')

@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
            <div class="ec-vendor-card-body">
                <div class="container">
                    <div class="row">

                        <div class="col-md-10 offset-2">
                            <div class="panel panel-default">
                                <h1>Change password</h1>

                                <div class="panel-body">

                                    <form class="form-horizontal" method="POST" action="{{ route('user.update_password') }}">
                                        @csrf

                                        <div class="form-group{{ $errors->has('current_password') ? '  has-error' : '' }}">
                                            <label for="new_password" class="col-md-4 control-label">Current
                                                Password</label>

                                            <div class="col-md-6">
                                                <input id="current-password" type="password" class="form-control"
                                                    name="current_password" required>


                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                            <label for="new_password" class="col-md-4 control-label mt-2">New
                                                Password</label>

                                            <div class="col-md-6">
                                                <input id="new_password" type="password" class="form-control"
                                                    name="new_password" required>


                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="new_password_confirm" class="col-md-4 control-label mt-2">Confirm
                                                New
                                                Password</label>

                                            <div class="col-md-6">
                                                <input id="new_password_confirm" type="password" class="form-control"
                                                    name="new_password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-danger rounded">
                                                    Update Password
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
