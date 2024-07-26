@extends('layouts.seller-dashboar')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">

        <div class="ec-vendor-dashboard-card ec-vendor-profile-card">
            <div class="ec-vendor-card-body">


                <div class="row">
                    <div class="col-md-12">
                        <div class="ec-vendor-block-profile">
                            <h4 class="mb-3">Banner 1</h4>
                            <form class="  " action="{{ route('vendor.banner.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row ">



                                    <div class="col-md-6">
                                        <label for="title" class="form-label">Ad title 1</label>
                                        <input type="text" name="meta[title1]" value="{{ auth()->user()->shop->title1 }}"
                                            class="form-control @error('meta') is-invalid @enderror" id="title1"
                                            required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="title" class="form-label">Ad Category 1</label>
                                        <input type="text" name="meta[category1]"
                                            value="{{ auth()->user()->shop->category1 }}"
                                            class="form-control @error('meta') is-invalid @enderror" id="category1"
                                            required>
                                        @error('category1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="title" class="form-label">Ad link 1</label>
                                        <input type="text" name="meta[link1]" value="{{ auth()->user()->shop->link1 }}"
                                            class="form-control @error('meta') is-invalid @enderror" id="link1"
                                            required>
                                        @error('link1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="image1" class="form-label">Image 1</label>
                                        <input type="file" name="meta[image1]" value=""
                                            class="form-control @error('name') is-invalid @enderror" id="image1"
                                            required>
                                        @error('image1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <img src="{{ Storage::url(auth()->user()->shop->image1) }}" alt=""
                                            height="80px">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-dark">Save</button>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5" style="border-bottom: 1px solid #b5b5b5; "></div>
                <div class="row mt-5">
                    <div class="col-md-12">
                        <div class="ec-vendor-block-profile">
                            <h4 class="mb-3">Banner 2</h4>
                            <form class="  " action="{{ route('vendor.banner.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row ">



                                    <div class="col-md-6">
                                        <label for="title" class="form-label">Ad title 2</label>
                                        <input type="text" name="meta[title2]"
                                            value="{{ auth()->user()->shop->title2 }}"
                                            class="form-control @error('meta') is-invalid @enderror" id="title2"
                                            required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="title" class="form-label">Ad Category 2</label>
                                        <input type="text" name="meta[category2]"
                                            value="{{ auth()->user()->shop->category2 }}"
                                            class="form-control @error('meta') is-invalid @enderror" id="category2"
                                            required>
                                        @error('category2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="title" class="form-label">Ad link 2</label>
                                        <input type="text" name="meta[link2]" value="{{ auth()->user()->shop->link2 }}"
                                            class="form-control @error('meta') is-invalid @enderror" id="link2"
                                            required>
                                        @error('link2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="image2" class="form-label">Image 2</label>
                                        <input type="file" name="meta[image2]" value=""
                                            class="form-control @error('name') is-invalid @enderror" id="image2"
                                            required>
                                        @error('image2')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <img src="{{ Storage::url(auth()->user()->shop->image2) }}" alt=""
                                            height="80px">
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
