@extends('layouts.seller-dashboard')
@section('dashboard-content')
<style>
    .btn-danger {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        color: #fff;
        background-color: #c12d3c;
        border-color: #c12d3c;
    }
</style>

<div class="ec-shop-rightside col-lg-9 col-md-12">
    <div class="ec-vendor-dashboard-card ec-vendor-profile-card">
        <div class="ec-vendor-card-body">


            <div class="row">
                <div class="col-md-12">
                    <div class="ec-vendor-block-profile">
                        <img src="{{ auth()->user()->shop ? Voyager::image(auth()->user()->shop->banner) : asset('assets/img/1.jpg') }}" alt="" style="    height: 190px;
                                    width: 100%;
                                    object-fit: cover;">
                        <div class="ec-vendor-block-img space-bottom-30" style="background-color: snow;">
                            <div class="ec-vendor-block-b"></div>
                            <div class="ec-vendor-block-detail">
                                <img class="v-img" src="{{ auth()->user()->shop ? Voyager::image(auth()->user()->shop->logo) : asset('assets/img/heaer.jpg') }}" style="object-fit: cover;" alt="vendor image">
                                <h5>{{ auth()->user()->name }}</h5>
                                <p>( {{ auth()->user()->shop ? auth()->user()->shop->name : 'no shop has been created' }}
                                    )</p>
                            </div>
                        </div>
                        {{-- @if( setting('site.shop_settings_info'))
                        <div class="card shadow">
                            <div class="card-body">
                                {!! setting('site.shop_settings_info') !!}
                            </div>
                        </div>
                        @endif --}}
                        {{-- <h3 class="mt-3 mb-3 text-center">General Info</h3>
                        <div class="pb-3" style="border-bottom: 1px solid #E1E1E1;">
                            <form method="POST" action="{{ route('vendor.generalInfo.update') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="ein">EIN(Employer Identification Number)</label>

                                            <input type="text" class=" @error('tax_no') is-invalid @enderror" value="{{ auth()->user()->verification->tax_no }}" id="tax_no" placeholder="Employer Identification Number" name="tax_no">
                                            @error('tax_no')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 my-2">
                                    <div class="form-group d-flex justify-content-end">
                                        <button class="btn btn-dark btn-lg" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}
                        <h3 class="mt-3 mb-3 text-center">Bank Information Edit</h3>
                        <div class="pb-3" style="border-bottom: 1px solid #E1E1E1;">
                            <form method="POST" action="{{ route('vendor.bankInfo.update') }}">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="ein">Account Holder Name</label>
                                            <input type="text" class=" @error('ac_holder_name') is-invalid @enderror" id="ac_holder_name" value="{{ auth()->user()->verification->ac_holder_name }}" placeholder="Account Holder Name" name="ac_holder_name">
                                            @error('ac_holder_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="ein">RTN Number</label>
                                            <input type="text" class=" @error('rtn') is-invalid @enderror" id="rtn" value="{{ auth()->user()->verification->rtn }}" placeholder="Routing Transit Number" name="rtn">
                                            @error('rtn')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12 my-2">
                                        <div class="form-group">
                                            <label for="ein">Paypal Email</label>
                                            <input type="text" class=" @error('paypal') is-invalid @enderror" id="paypal" value="{{ auth()->user()->verification ? auth()->user()->verification->paypal : '' }}" placeholder="Paypal Account for payouts" name="paypal">
                                            @error('paypal')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="ein">Bank Ac Number</label>
                                            <input type="text" class=" @error('bank_ac') is-invalid @enderror" id="bank_ac" value="{{ auth()->user()->verification->bank_ac }}" placeholder="Bank Account number" name="bank_account_number">
                                            @error('bank_account_number')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="ein">Re-Enter Bank Ac Number</label>
                                            <input type="text" class=" @error('bank_account_number_confirmation') is-invalid @enderror" id="bank_account_number_confirmation" value="{{ auth()->user()->verification->bank_ac }}" placeholder="Bank Account number" name="bank_account_number_confirmation">
                                            @error('bank_account_number_confirmation')
                                            <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="col-md-12 my-2">
                                    <div class="form-group d-flex justify-content-end">
                                        <button class="butn-dark2" type="submit"><span>Update</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <h3 class="mt-3 mb-3 text-center">Address Edit</h3>
                        <div class="pb-3" style="border-bottom: 1px solid #E1E1E1;">
                            <form method="POST" action="{{ route('vendor.shopAddress.update') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="address">Street address<span class="text-danger">*</span></label>
                                            <textarea id="address" placeholder="Address" class="mb-3  @error('meta.address') is-invalid @enderror" name="meta[address]" required>{{auth()->user()->address ? auth()->user()->address : '' }}</textarea>

                                            @error('meta.address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="ein">City</label>
                                            <input type="text" value="{{  auth()->user()->city ?  auth()->user()->city : old('meta.city') }}" class=" @error('city') is-invalid @enderror" id="city" placeholder="City" name="meta[city]">
                                            @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="ein">State</label>
                                            @php
                                           $states = ['Capital Region of Denmark', 'Central Denmark Region', 'North Denmark Region', 'Region Zealand', 'Region of Southern Denmark	'];
                                            @endphp

                                            <select id="inputState" class="bg-light form-select  mx-0 border @error('state') is-invalid @enderror" name="meta[state]" id="state" required>
                                                <option selected value="">Choose State</option>

                                                @foreach ($states as $state)
                                          
                                                <option value="{{ $state }}" {{ auth()->user()->state == $state ? 'selected' : '' }}>
                                                    {{ $state }}
                                                </option>
                                                @endforeach


                                            </select>
                                            @error('meta.state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <div class="form-group">
                                            <label for="ein">Country</label>
                                            <select class="bg-light form-select  mx-0 border  @error('country') is-invalid @enderror" name="meta[country]" id="country" required>
                                                <option selected value="">Choose Country</option>

                                                <option value="Denmark" {{ auth()->user()->country == 'Denmark' ? 'selected' : '' }}>
                                                    Denmark</option>
                                         
                                            </select>
                                            @error('meta.country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror

                                        </div>
                                    </div>


                                </div>

                                <div class="col-md-12 my-2">
                                    <div class="form-group d-flex justify-content-end">
                                        <button class="btn btn-dark btn-lg" type="submit"><span>Update</span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- <div class="mt-5" style="border-bottom: 1px solid #b5b5b5; "></div> --}}
                        {{-- <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="ec-vendor-block-profile">
                                    <h4 class="mb-3">Shop Menu bar</h4>
                                    <form class="  " action="{{ route('vendor.shopMenuStore.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row ">



                                            <div class="col-md-6">
                                                <label for="title" class="form-label ">Menu Title 1</label>
                                                <input type="text" name="meta[menuTitle1]" value="{{ auth()->user()->shop->menuTitle1 }}" class=" @error('meta.menuTitle1') is-invalid @enderror" id="menuTitle1">
                                                @error('meta.menuTitle]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror

                                            </div>
                                            <div class="col-md-6">
                                                <label for="title" class="form-label">Menu Link 1</label>
                                                <input type="text" name="meta[menuLink1]" value="{{ auth()->user()->shop->menuLink1 }}" class=" @error('meta.menuLink1') is-invalid @enderror" id="menuLink1">
                                                @error('meta.menuLink1')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label for="title" class="form-label ">Menu Title 2</label>
                                                <input type="text" name="meta[menuTitle2]" value="{{ auth()->user()->shop->menuTitle2 }}" class=" @error('meta.menuTitle2') is-invalid @enderror" id="menuTitle2">
                                                @error('meta.menuTitle2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror

                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <label for="title" class="form-label">Menu Link 2</label>
                                                <input type="text" name="meta[menuLink2]" value="{{ auth()->user()->shop->menuLink2 }}" class=" @error('meta.menuLink2') is-invalid @enderror" id="menuLink2">
                                                @error('meta.menuLink2')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group d-flex justify-content-end">
                                            <button class="btn btn-dark btn-lg mt-3" type="submit"> Save</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div> --}}
                        <h3 class="mt-3 mb-3 text-center">Change Password</h3>
                        <form method="POST" action="{{ route('vendor.ChangePassword') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 my-2">
                                    <div class="form-group">

                                        <input type="password" class=" @error('current_password') is-invalid @enderror" id="current_password" placeholder="current password" name="current_password">
                                        @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="form-group">

                                        <input type="password" class=" @error('new_password') is-invalid @enderror" id="new_password" placeholder="new password" name="new_password">
                                        @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </form>
                    
                            <div class="col-md-12 my-2">
                                <div class="form-group">

                                    <input type="password" class=" @error('new_confirm_password') is-invalid @enderror" id="new_confirm_password" placeholder="Confirm password" name="new_confirm_password">
                                    @error('new_confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 my-2">
                                <div class="form-group d-flex justify-content-end">
                                    <button class="butn-dark2" type="submit"> <span>Change Password</span></button>
                                </div>
                            </div>

                        </form>
                  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection