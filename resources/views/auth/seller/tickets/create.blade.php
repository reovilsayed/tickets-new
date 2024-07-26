@extends('layouts.seller-dashboard')
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-dashboard-card">
            <div class="ec-vendor-card-body">
                <form action="{{ route('vendor.ticket.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="">
                            <div class="ec-vendor-upload-detail">
                                <div class="row g-3">
                                    <div class=" mt-2">
                                        <label for="inputEmail4" class="form-label">Subject<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('subject') }}"
                                            class=" @error('subject') is-invalid @enderror" name="subject"
                                            id="subject">

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label class="form-label">Massage <span class="text-danger">*</span></label>
                                        <textarea class=" @error('Massage') is-invalid @enderror" name="massage" rows="2">{{ old('massage') }}</textarea>

                                        @error('massage')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class=" mt-2">
                                        <label for="inputEmail4" class="form-label">Image<span
                                                class="text-danger">*</span></label>
                                        <input type="file" value="{{ old('image') }}"
                                            class=" @error('image') is-invalid @enderror" name="image"
                                            id="image">

                                        @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>







                                    <div class="col-md-12 mt-2 rounded">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
