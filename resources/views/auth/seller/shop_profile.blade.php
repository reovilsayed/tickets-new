@php
$shop=Auth()->user()->shop;
@endphp
@extends('layouts.seller-dashboard')

@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12" style="position: relative;">
        <div class="ec-vendor-dashboard-card ec-vendor-profile-card">
            @if (auth()->user()->shop)
                @if (auth()->user()->shop->status == 0)
                    <div class="card-header text-center">
                        <span style="color: red">Your shop is pending approval. We'll notify you once it's approved.</span>
                    </div>
                @endif
            @endif
            <div class="ec-vendor-card-body">


                <div class="row">
                    <div class="col-md-12">
                        <div class="ec-vendor-block-profile">
                            <img src="{{ auth()->user()->shop && auth()->user()->shop->banner ? Voyager::image(auth()->user()->shop->banner) : asset('assets/img/1.jpg') }}"
                                alt=""
                                style="height: 190px;
                                    width: 100%;
                                    object-fit: cover;">
                            <a href="javascript:void(0)" class="shadow-lg"
                                style="position: absolute; top:0px; right:20px; background-color: #fff; border-radius:50%;padding:10px 0"
                                data-bs-toggle="modal" data-bs-target="#coverModal"><span class="mx-3"><i
                                        class="fi-rr-edit" style="font-size: 16px;"></i></span></a>
                            <div class="ec-vendor-block-img space-bottom-30" style="background-color: snow;">
                                <div class="ec-vendor-block-b"></div>
                                <div class="ec-vendor-block-detail">
                                    <div style="position: relative;">

                                        <img class="v-img" style="object-fit: cover;"
                                            src="{{ auth()->user()->shop && auth()->user()->shop->logo ? Voyager::image(auth()->user()->shop->logo) : asset('assets/img/heaer.jpg') }}"
                                            alt="vendor image">
                                        <a href="javascript:void(0)" class="shadow-lg"
                                            style="position: absolute; top:-59px; right:-21px; background-color: #fff; border-radius:50%;padding:10px 0"
                                            data-bs-toggle="modal" data-bs-target="#logoModal"><span class="mx-3"><i
                                                    class="fi-rr-edit" style="font-size: 16px;"></i></span></a>
                                    </div>
                                    <h5>{{ auth()->user()->name }}</h5>
                                    <p>( {{ auth()->user()->shop ? auth()->user()->shop->name : 'no shop has been created' }}
                                        )</p>
                                </div>
                            </div>
                            <form class="row g-3 " action="{{ route('vendor.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12 mb-3 form-group">
                                    <label for="name" class="form-label">Shop Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                        value="{{ $shop ? auth()->user()->shop->name ? auth()->user()->shop->name :old('name') :'' }}"
                                        class=" @error('name') is-invalid @enderror" id="name" >
                                    @error('name')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="col-12 mb-3">
                                    <div class="form-group ">
                                        <label for="floatingTextarea2">Short Description<span
                                                class="text-danger">*</span></label>
                                        <textarea class=" @error('short_description') is-invalid @enderror" placeholder="Short Description"
                                            name="short_description" id="short_description" style="height: 100px" >{{ $shop ? auth()->user()->shop->short_description ? auth()->user()->shop->short_description : old('short_description') :'' }}</textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 form-group">
                                    <label for="inputEmail4" class="form-label">Shop Email<span
                                            class="text-danger">*</span></label>
                                    <input type="email" class=" @error('email') is-invalid @enderror"
                                        value="{{ $shop ? $shop->email ? $shop->email : old('email') :'' }}" name="email"
                                        id="inputEmail4" >
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3 form-group">
                                    <label for="inputEmail4" class="form-label">Shop Phone Number<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class=" @error('phone') is-invalid @enderror"
                                        value="{{ $shop ? $shop->phone ? $shop->phone : old('phone') :'' }}" name="phone"
                                        id="phone" >
                                    @error('phone')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-6 mb-2">
                                <label for="inputEmail4" class="form-label">Shop Tags <span>( Type and
                                        make comma to separate tags And Use Three word to describe your shop
                                        )</span><span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror" value="{{ auth()->user()->shop ? auth()->user()->shop->tags : ' ' }}" data-role="tagsinput" name="tags" id="group_tag">
                                @error('tags')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div> --}}
                                {{-- <div class="col-md-6 mb-3 form-group">
                                    <label for="inputEmail4" class="form-label">Company Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class=" @error('company_name') is-invalid @enderror"
                                        value="{{ auth()->user()->shop ? auth()->user()->shop->company_name : old('company_name') }}"
                                        name="company_name" id="company_name" required>
                                    @error('company_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}
                                {{-- <div class="col-md-6 mb-3 form-group">
                                    <label for="inputEmail4" class="form-label">Shop Address<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class=" @error('company_registration') is-invalid @enderror"
                                        value="{{ auth()->user()->shop ? auth()->user()->shop->company_registration :  }}"
                                        name="company_registration" id="company_registration" required>
                                    @error('company_registration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

                                <div class="col-md-6 mb-3 form-group">
                                    <label for="inputCity" class="form-label">Country<span
                                            class="text-danger">*</span></label>
                                    {{-- <select class="form-select border @error('meta.country') is-invalid @enderror"
                                        name="country" id="country" required>
                                        <option selected value="">Choose Country</option>
                                        @if (auth()->user()->shop)
                                            <option
                                                {{ auth()->user()->shop->country == 'Denmark' ? 'selected' : '' }}
                                                value="Denmark">Denmark</option>
                                        @else
                                            <option value="Denmark">Denmark</option>
                                        @endif
                                    </select> --}}
                                    <input type="text" name="country" id="country" class="from-group @error('country') is-invalid @enderror" value="{{auth()->user()->shop->country ? auth()->user()->shop->country :old('country') }}" >
                                    @error('country')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @php
                                    $states = ['Capital Region of Denmark', 'Central Denmark Region', 'North Denmark Region', 'Region Zealand', 'Region of Southern Denmark	'];
                                @endphp

                                <div class="col-md-6 mb-3">
                                    <label for="inputState" class="form-label">State<span
                                            class="text-danger">*</span></label>
                                    {{-- <select id="inputState" class=" form-select border @error('state') is-invalid @enderror"
                                        name="state" id="state" required>
                                        <option selected value="">Choose State</option>

                                        @foreach ($states as $state)
                                            @if (auth()->user()->shop)
                                                <option value="{{ $state }}"
                                                    {{ auth()->user()->shop->state == $state ? 'selected' : '' }}>
                                                    {{ $state }}</option>
                                            @else
                                                <option value="{{ $state }}">
                                                    {{ $state }}</option>
                                            @endif
                                        @endforeach


                                    </select> --}}
                                    <input type="text" name="state" id="state" class="from-group @error('state') is-invalid @enderror" value="{{auth()->user()->shop->state ? auth()->user()->shop->state :old('state') }}" >
                                    @error('state')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3 form-group">
                                    <label for="inputCity" class="form-label">City<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class=" @error('city') is-invalid @enderror"
                                        value="{{ $shop ? $shop->city ? $shop->city : old('city') :'' }}"
                                        name="city" id="city" required>
                                    @error('city')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3 form-group">
                                    <label for="inputZip" class="form-label">Zip</label>
                                    <input type="text"
                                        class="p-2 @error('post_code') is-invalid @enderror"
                                        value="{{ $shop ? $shop->post_code ? $shop->post_code : old('post_code') :'' }}"
                                        name="post_code" id="post_code" >
                                    @error('post_code')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="inputAddress2" class="form-label">About Shop<span
                                            class="text-danger">*</span></label>
                                    <textarea name="description" class="@error('description') is-invalid @enderror"  >{{ $shop ? $shop->description ?$shop->description : old('description') :'' }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="col-12 mt-3 d-flex justify-content-end">
                                    <button type="submit" class="butn-dark2 mt-3"><span>Save</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-12">
                        <div class="ec-vendor-block-profile">
                            <h4 class="mb-3">Shop Social Links</h4>
                            <form action="{{ route('vendor.shopSocialLinksStore.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-6">
                                        <label for="title" class="form-label">Facebook</label>
                                        <input type="text" name="meta[facebook]"
                                            value="{{ auth()->user()->shop ? auth()->user()->shop->facebook : '' }}"
                                            class=" @error('meta') is-invalid @enderror" id="title">
                                        @error('meta.*.facebook')
                                            <p>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="title2" class="form-label">Linkedin</label>
                                        <input type="text" name="meta[linkedin]"
                                            value="{{ auth()->user()->shop ? auth()->user()->shop->linkedin : '' }}"
                                            class=" @error('meta') is-invalid @enderror" id="title2">
                                        @error('meta.*.linkedin')
                                            <p>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="title3" class="form-label">Instagram</label>
                                        <input type="text" name="meta[instagram]"
                                            value="{{ auth()->user()->shop ? auth()->user()->shop->instagram : '' }}"
                                            class="@error('meta') is-invalid @enderror" id="title3">
                                        @error('meta.*.instagram')
                                            <p>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="title4" class="form-label">Twitter</label>
                                        <input type="text" name="meta[twitter]"
                                            value="{{ auth()->user()->shop ? auth()->user()->shop->twitter : '' }}"
                                            class="@error('meta') is-invalid @enderror" id="title4">
                                        @error('meta.*.twitter')
                                            <p>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                </div>
                        

                                   <button class="butn-dark2 mt-3" type="submit" ><span>Save</span></button>
                              

                            </form>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
