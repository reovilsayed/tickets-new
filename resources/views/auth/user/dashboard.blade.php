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
                <div class="row">

                    <div class="col-md-12">
                        <div class="ec-vendor-block-profile">
                            <div class="ec-vendor-block-img space-bottom-30">
                                <div>

                                    <h4 class="dashboard-title">
                                        Personal Information
                                    </h4>
                                    <div class="table-responsive">
                                        <table class="dashboard-table ">
                                            <tr>
                                                <th>
                                                    Name :
                                                </th>
                                                <td>
                                                    {{ auth()->user()->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Email :
                                                </th>
                                                <td>
                                                    {{ auth()->user()->email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Phone :
                                                </th>
                                                <td>
                                                    {{ Auth::user()->contact_number }}
                                                </td>
                                            </tr>
                                           
                                            <tr>
                                                <th>
                                                    Address :
                                                </th>
                                                <td>
                                                    {{ auth()->user()->address ?? 'N/A' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Taxpayer :
                                                </th>
                                                <td>
                                                    {{ auth()->user()->vatNumber ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <a class="dashboard-edit" href="{{ route('user.update_profile') }}"><i
                                            class="fa fa-edit fa-2x"></i></a>
                                </div>


                            </div>



                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
