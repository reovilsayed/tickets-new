@extends('layouts.seller-dashboard')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/multiple-select.css') }}">
@endsection
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-dashboard-card">
            <div class="ec-vendor-card-body">
                <form action="{{ route('vendor.product.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-lg-4">
                            <div class="ec-vendor-img-upload">
                                <div class="ec-vendor-main-img">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' id="imageUpload" name="image" class="ec-image-upload"
                                                accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload"><i class="fi-rr-edit"></i></label>
                                        </div>
                                        <div class="avatar-preview ec-preview">
                                            <div class="imagePreview ec-div-preview">
                                                <img class="ec-image-preview" src="{{ asset('assets/img/upload.jpg') }}"
                                                    alt="edit" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumb-upload-set colo-md-12">
                                        <div class="thumb-upload">
                                            <div class="thumb-edit">
                                                <input type='file' id="thumbUpload01" name="images[0]"
                                                    class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload"><i class="fi-rr-edit"></i></label>
                                            </div>
                                            <div class="thumb-preview ec-preview">
                                                <div class="image-thumb-preview">
                                                    <img class="image-thumb-preview ec-image-preview"
                                                        src="{{ asset('assets/img/upload.jpg') }}" alt="edit" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb-upload">
                                            <div class="thumb-edit">
                                                <input type='file' id="thumbUpload02" name="images[1]"
                                                    class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload"><i class="fi-rr-edit"></i></label>
                                            </div>
                                            <div class="thumb-preview ec-preview">
                                                <div class="image-thumb-preview">
                                                    <img class="image-thumb-preview ec-image-preview"
                                                        src="{{ asset('assets/img/upload.jpg') }}" alt="edit" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb-upload">
                                            <div class="thumb-edit">
                                                <input type='file' id="thumbUpload03" name="images[2]"
                                                    class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload"><i class="fi-rr-edit"></i></label>
                                            </div>
                                            <div class="thumb-preview ec-preview">
                                                <div class="image-thumb-preview">
                                                    <img class="image-thumb-preview ec-image-preview"
                                                        src="{{ asset('assets/img/upload.jpg') }}" alt="edit" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb-upload">
                                            <div class="thumb-edit">
                                                <input type='file' id="thumbUpload04" name="images[3]"
                                                    class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload"><i class="fi-rr-edit"></i></label>
                                            </div>
                                            <div class="thumb-preview ec-preview">
                                                <div class="image-thumb-preview">
                                                    <img class="image-thumb-preview ec-image-preview"
                                                        src="{{ asset('assets/img/upload.jpg') }}" alt="edit" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb-upload">
                                            <div class="thumb-edit">
                                                <input type='file' id="thumbUpload05" name="images[4]"
                                                    class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload"><i class="fi-rr-edit"></i></label>
                                            </div>
                                            <div class="thumb-preview ec-preview">
                                                <div class="image-thumb-preview">
                                                    <img class="image-thumb-preview ec-image-preview"
                                                        src="{{ asset('assets/img/upload.jpg') }}" alt="edit" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb-upload">
                                            <div class="thumb-edit">
                                                <input type='file' id="thumbUpload06" name="images[5]"
                                                    class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                                <label for="imageUpload"><i class="fi-rr-edit"></i></label>
                                            </div>
                                            <div class="thumb-preview ec-preview">
                                                <div class="image-thumb-preview">
                                                    <img class="image-thumb-preview ec-image-preview"
                                                        src="{{ asset('assets/img/upload.jpg') }}" alt="edit" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="ec-vendor-upload-detail">
                                <div class="row g-3">
                                    <div class="col-md-12 mt-2">
                                        {{-- <label for="inputEmail4" class="form-label">Product name<span class="text-danger">*</span></label> --}}
                                        <input type="text" placeholder="name *" value="{{ old('name') }}"
                                            class=" @error('name') is-invalid @enderror" name="name" id="inputEmail4">

                                        @error('name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="form-label">Select Categories <span
                                                class="text-danger">*</span></label>
                                        <select multiple
                                            class="w-100 form-control form-select border @error('categories') is-invalid @enderror"
                                            data-placeholder="Select Categories" name="categories[]">
                                            @foreach ($prodcats as $prodcat)
                                                <option value="{{ $prodcat->id }}">{{ $prodcat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('categories')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label class="form-label">Short Description <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" name="short_description"
                                            id="short_description">{{ old('short_description') }}</textarea>

                                        @error('short_description')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-6 mt-2">
                                    <label class="form-label">Tags </label>
                                    <input type="text" name="input" class="form-control" placeholder="">
                                    <p class="text-danger" id=""></p>
                                </div> --}}

                                    <div class="col-md-6 mt-2">
                                        {{-- <label class="form-label">  <span class="text-danger">*</span></label> --}}
                                        <input type="text" placeholder="Price *" name="price"
                                            value="{{ old('price') }}" class="@error('price') is-invalid @enderror"
                                            id="price">
                                        <p class="text-danger" id=""> </p>
                                        @error('price')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        {{-- <label class="form-label">saleprice </label> --}}
                                        <input type="text" placeholder="Sale Price" name="sale_price"
                                            value="{{ old('sale_price') }}" class="" id="salePrice">
                                        <p class="text-danger" id=""></p>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        {{-- <label class="form-label">Quantity <span class="text-danger">*</span></label> --}}
                                        <input type="text" placeholder="Quantity *" name="quantity"
                                            value="{{ old('quantity') }}"
                                            class="  @error('quantity') is-invalid @enderror" id="quantity">

                                        @error('quantity')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                   
                                <div class="col-md-6 my-3">
                                    <label for="city_id" class="form-label">City *</label>
                                    <select  class=" form-select border @error('city_id') is-invalid @enderror"
                                        name="city_id" id="city_id" required>
                                        <option selected value="">Choose City</option>

                                        @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">
                                                    {{ $city->name }}</option>
                                           
                                        @endforeach


                                    </select>
                                    @error('city_id')
                                        <span class="invalid-feedback text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                    {{-- <div class="col-md-12 mt-2">
                                    <!-- <label class="form-label">Admin Price </label> -->
                                    <input type="hidden" name="vendor_price" value="" class="form-control" id="vendorPrice">
                                </div> --}}

                               
                                    <div class="col-md-6 mt-2">
                                        <label class="form-label">Expired at * </label>
                                        <input type="date" placeholder="" name="expired_at"
                                            value="{{ old('expired_at') }}" class="" id="expired_at">
                                        @error('expired_at')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="form-label">Full Details <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="4"
                                            id="description">{{ old('description') }}</textarea>

                                        @error('description')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <label for="amenities" class="form-label">Amenities <span>( Type and
                                                make comma to separate Amenities
                                                )</span><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                            value="{{ old('amenities') }}" data-role="tagsinput" name="amenities"
                                            id="amenities">
                                        @error('amenities')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-6 mt-2">
                                    <label class="form-label">Product weight</label>
                                    <input type="text" class="form-control" value="{{old('weight')}}" placeholder="179 grams" name="weight" />
                                </div> --}}



                                    <!-- <div class="col-md-6 mt-2">

                                            <label class="form-label">Color <span>( Type Color name and
                                                    make comma to separate sizes )</span></label>
                                            <input type="text" class="form-control" id="group_tag" name="color" value="" placeholder="" data-role="tagsinput" />

                                        </div> -->

                                    <!-- <div class="col-md-6 mt-2">

                                                <label class="form-label">Sizes <span>( Type and
                                                        make comma to separate sizes )</span></label>
                                                <input type="text" class="form-control" id="group_tag" name="sizes" value="" placeholder="" data-role="tagsinput" />

                                            </div> -->
                                    {{-- <div class="col-md-6 mt-2">
                                        <label class="form-label">Product Dimensions</label>
                                        <input type="text" class="form-control" value="{{old('dimensions')}}" placeholder="159.9 x 73.9 x 8.1 millimeters" name="dimensions" />
                                    </div> --}}


                                    {{-- <div class="d-flex">
                                    <input type="checkbox" id="is_variable_product" style="width: 25px;" value="1" name="is_variable_product">
                                    <label for="offer" class="mt-3 ms-3">
                                        Variable Product
                                    </label>
                                </div>
                                <div class="d-flex">
                                    <input type="checkbox" id="offer" style="width: 25px;" value="1" name="offer">
                                    <label for="offer" class="mt-3 ms-3">
                                        Allow make offer
                                    </label>
                                </div> --}}
                                    <input type="hidden" name="post_code"
                                        value="{{ auth()->user()->shop->post_code }}">

                                    <div class="col-md-12 mt-2">
                                        <button type="submit" class="butn-dark2"><span>Submit</span></button>
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
@section('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    <script>
        // $(document).ready(function() {
        //     document.getElementById('price')

        //     $('#salePrice, #price').blur(function() {
        //         // sale price calculation 
        //         var salePrice = $('#salePrice').val();
        //         var newSalePrice = parseFloat(salePrice);
        //         var salePricePercentageWithTen = (newSalePrice) * .1;
        //         var salePricePercentageWithsix = (newSalePrice) * .06;

        //         // price calculation 
        //         var price = $('#price').val();
        //         var newPrice = parseFloat(price);
        //         var pricePercentageWithTen = (newPrice) * .1;
        //         var pricePercentageWithsix = (newPrice) * .06;
        //         console.log(salePricePercentageWithTen);



        //         if (salePrice > 0) {


        //             if (salePrice < 1000) {
        //                 var vendorPrice = newSalePrice - pricePercentageWithTen;
        //                 $('#priceMassage').text('Platform will receive' + ' 10% of ' + salePrice + ', equaling ' + parseFloat(salePricePercentageWithTen).toFixed(2) + ', and you will receive ' + (newSalePrice - salePricePercentageWithTen) + '.');
        //                 $('#vendorPrice').val(vendorPrice);

        //             } else {
        //                 vendorPrice = newSalePrice - salePricePercentageWithsix;
        //                 $('#priceMassage').text('Platform will receive' + ' 6% of ' + salePrice + ', equaling ' + parseFloat(salePricePercentageWithsix).toFixed(2) + ', and you will receive ' + (newSalePrice - salePricePercentageWithsix) + '.');
        //                 $('#vendorPrice').val(vendorPrice);
        //             }
        //             $('#salePriceMassage').text('You offered a ' + parseFloat((price - salePrice) / price * 100).toFixed(2) + '% discount.')

        //             console.log((price - salePrice) / price * 100);
        //         } else {


        //             if (price < 1000) {
        //                 var vendorPrice = newPrice - pricePercentageWithTen;
        //                 $('#priceMassage').text('Platform will receive' + ' 10% of ' + price + ', equaling ' + parseFloat(pricePercentageWithTen).toFixed(2) + ', and you will receive ' + (newPrice - pricePercentageWithTen) + '.');
        //                 $('#vendorPrice').val(vendorPrice);
        //             } else {
        //                 var vendorPrice = newPrice + pricePercentageWithsix;
        //                 $('#priceMassage').text('Platform will receive' + ' 10% of ' + price + ', equaling ' + parseFloat(pricePercentageWithsix).toFixed(2) + ', and you will receive ' + (newPrice - pricePercentageWithsix) + '.');
        //                 $('#vendorPrice').val(vendorPrice);
        //             }
        //         }


        //     });
        // });
    </script>
    <script>
        $(document).ready(function() {
            $('#variableCheck').on('change', function() {
                // Toggle visibility of elements based on checkbox status
                if ($(this).is(':checked')) {
                    $('#variableFileds').show();
                } else {
                    $('#variableFileds').hide();
                }
            });
        })
    </script>


    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#description').summernote({
            height: 200
        });
        $('#short_description').summernote({
            height: 200
        });
    </script>
@endsection
