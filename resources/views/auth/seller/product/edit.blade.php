@extends('layouts.seller-dashboard')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/multiple-select.css') }}">
    
@endsection
@section('dashboard-content')
    @php
        $images = json_decode($product->images);
        $variatImg = json_decode($product->image);
    @endphp
    <!-- Vendor upload section -->


    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-dashboard-card">
            <div class="ec-vendor-card-body">
                <form action="{{ route('vendor.product.update', $product) }}" method="post" enctype="multipart/form-data">
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
                                                <img class="ec-image-preview" src="{{ Voyager::image($product->image) }}"
                                                    alt="edit" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumb-upload-set colo-md-12">

                                        <div class="thumb-upload">
                                            <div class="thumb-edit">
                                                <input type='file' id="thumbUpload06" name="newimages"
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

                                        @if ($images)
                                            @foreach ($images as $key => $image)
                                                <div class="thumb-upload">
                                                    <div class="thumb-edit">
                                                        <input type='file' id="thumbUpload02"
                                                            name="images[{{ $key }}]" class="ec-image-upload"
                                                            accept=".png, .jpg, .jpeg" />
                                                        <label for="imageUpload"><i class="fi-rr-edit"></i></label>
                                                    </div>
                                                    <div class="thumb-preview ec-preview">
                                                        <div class="image-thumb-preview">
                                                            <img class="image-thumb-preview ec-image-preview"
                                                                src="{{ Voyager::image($image) }}" alt="edit" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif



                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="ec-vendor-upload-detail">
                                <div class="row g-3">
                                    <div class="col-md-12 mt-2">
                                        <label for="inputEmail4" class="form-label">Product name</label>
                                        <input type="text" class=" @error('name') is-invalid @enderror"
                                            value="{{ $product->name }}" name="name" id="inputEmail4">
                                        @error('name')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label class="form-label">Select Categories</label>
                                        <select multiple data-placeholder="Select Categories"
                                            class="@error('categories') is-invalid @enderror" name="categories[]">
                                            @foreach ($prodcats as $prodcat)
                                                <option value="{{ $prodcat->id }}"
                                                    {{ $product->prodcats->contains($prodcat->id) ? 'selected' : '' }}>
                                                    {{ $prodcat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('categories')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="form-label">Short Description</label>
                                        <textarea id="short_description" class="form-control @error('short_description') is-invalid @enderror"
                                            name="short_description" rows="2">{{ $product->short_description }}</textarea>
                                        @error('short_description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label class="form-label">Price </label>
                                        <input type="text" value="{{ $product->price }}" name="price"
                                            class=" @error('price') is-invalid @enderror" id="price">
                                        <p class="text-danger" id="priceMassage"> </p>
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label class="form-label">Sale price </label>
                                        <input type="text" value="{{ $product->sale_price }}" name="sale_price"
                                            class=" @error('sale_price') is-invalid @enderror" id="salePrice">
                                        <p class="text-danger" id="salePriceMassage"></p>
                                        @error('sale_price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-12 mt-2">

                                        <input type="hidden" name="vendor_price" value="" class="form-control"
                                            id="vendorPrice" readonly>
                                    </div> --}}

                                    <div class="col-md-12 mt-2">
                                        <label class="form-label">Quantity</label>
                                        <input type="text" value="{{ $product->quantity }}" name="quantity"
                                            class=" @error('quantity') is-invalid @enderror" id="quantity1">
                                        @error('quantity')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 my-3">
                                        <label for="city_id" class="form-label">City </label>
                                        <select  class=" form-select border @error('city_id') is-invalid @enderror"
                                            name="city_id" id="city_id" required>
                                            <option selected value="">Choose City</option>
    
                                            @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" {{$product->city->id==$city->id ? 'selected' :''}}>
                                                        {{ $city->name }}</option>
                                               
                                            @endforeach
    
    
                                        </select>
                                        @error('city_id')
                                            <span class="invalid-feedback text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label class="form-label">Expired at</label>
                                        <input type="date" value="{{ $product->expired_at->format('Y-m-d') }}" name="expired_at"
                                            class=" @error('expired_at') is-invalid @enderror" id="city">
                                        @error('expired_at')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label class="form-label">Ful Detail</label>
                                        <textarea id="description" class="form-control  @error('description') is-invalid @enderror" name="description"
                                            rows="4">{{ $product->description }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <label for="amenities" class="form-label">Amenities <span>( Type and
                                                make comma to separate Amenities
                                                )</span><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                            value="{{ $product->amenities }}"
                                            data-role="tagsinput" name="amenities" id="amenities">
                                        @error('amenities')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-6 mt-2">
                                        <label class="form-label">Product weight</label>
                                        <input type="text" value="{{ $product->weight }}"
                                            class="form-control @error('weight') is-invalid @enderror"
                                            placeholder="179 grams" name="weight" />
                                        @error('weight')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}
                                    {{-- <div class="col-md-6 mt-2">
                                        <label class="form-label">Product Dimensions</label>
                                        <input type="text" value="{{ $product->dimensions }}"
                                            class="form-control @error('dimensions') is-invalid @enderror"
                                            placeholder="159.9 x 73.9 x 8.1 millimeters" name="dimensions" />
                                        @error('dimensions')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}


                                    <!-- <div class="col-md-6 mt-3">

                                        <label class="form-label">Color <span>( Type Color name and
                                                make comma to separate sizes )</span></label>
                                        <input type="text" class="form-control" id="group_tag" name="color" value="{{ $product->color }}" placeholder="" data-role="tagsinput" />

                                    </div> -->



                                    <!-- <div class="col-md-6 mt-3">

                                        <label class="form-label">Sizes <span>( Type and
                                                make comma to separate sizes )</span></label>
                                        <input type="text" class="form-control" id="group_tag" name="sizes" value="{{ $product->sizes }}" placeholder="" data-role="tagsinput" />

                                    </div> -->



                                    {{-- <div class="d-flex">
                                        <input {{ $product->is_offer == true ? 'checked' : '' }} type="checkbox"
                                            id="offer" style="width: 25px;" value="1" name="offer">
                                        <label for="offer" class="mt-3 ms-3">
                                            Allow make offer
                                        </label>
                                    </div> --}}
                                    <input type="hidden" name="post_code"
                                        value="{{ auth()->user()->shop->post_code }}">
                                    <div class="col-md-12 mt-2">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- <div id="attribute_variation"></div>
        @if ($product->is_variable_product && $product->id)
            <div class="page-content edit-add container-fluid mt-3">
                <div class="row">
                    <div class="col-md-8 order-md-2 border p-3 mx-auto">
                        <div class="panel panel-bordered">
                            <ul class="nav nav-tabs bg-light p-3">
                                <li class="<?php if (session()->get('target') == 'attribute') {
                                    echo 'active';
                                } ?> me-3"><a data-bs-toggle="tab" href="#attribute"
                                        class="text-primary">Attribute</a></li>
                                <li class="<?php if (session()->get('target') == 'variation') {
                                    echo 'active';
                                } ?>"><a data-bs-toggle="tab" href="#variable_product_id"
                                        id="variation_btn">Variation</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="attribute" class="tab-pane fade <?php if (session()->get('target') == 'attribute') {
                                    echo 'show active';
                                } ?>">
                                    <form action="{{ route('vendor.store.attribute') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="form-group">
                                            <input type="text" class="form-control mb-2" name="attr_name"
                                                placeholder="Color,Size etc" required>
                                            <input style="" type="text" class="form-control mt-2 mb-2"
                                                name="attr_value" data-role="tagsinput"
                                                placeholder="Attribute value comma separated red,yellow,white etc"
                                                required="" value="">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                    @foreach ($product_attributes as $product_attribute)
                                        <?php $attribute_value = implode(',', $product_attribute->value); ?>
                                        <form action="{{ route('vendor.update.attribute') }}" method="post">
                                            @csrf
                                            <div class="form-group mt-3">
                                                <input type="text" class="form-control mb-2" name="attr_name"
                                                    placeholder="Color,Size etc" required=""
                                                    value="{{ str_replace('_', ' ', $product_attribute->name) }}">
                                                <input type="hidden" value="{{ $product_attribute->id }}"
                                                    name="attr_id">
                                                <input class="form-control" name="attr_value" data-role="tagsinput"
                                                    placeholder="Attribute value comma separated red,yellow,white etc"
                                                    value="{{ str_replace('_', ' ', $attribute_value) }}" required="">
                                                <br>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <a href="{{ route('vendor.delete.product.attribute', $product_attribute->id) }}"
                                                    class="remove_button btn btn-danger bg-danger text-white"
                                                    onclick="cskDelete()">Remove</a>
                                            </div>
                                        </form>
                                    @endforeach
                                </div>
                                <div id="variable_product_id" class="tab-pane fade <?php if (session()->get('target') == 'variation') {
                                    echo 'show active';
                                } ?>">
                                    <a href="{{ route('vendor.new.variation', $product->id) }}"
                                        class="btn btn-primary">Add New</a>
                                    <a href="{{ route('vendor.create.all.variation', $product->id) }}"
                                        class="btn btn-primary">Add All Variations</a>

                                    <a href="{{ route('vendor.delete.all.child', $product->id) }}"
                                        class="btn btn-danger bg-danger text-white">Delete All</a>
                        

                                    <div id="accordion">
                                        @if($product->subproducts)
                                        @foreach ($product->subproducts as $variable_product)
                                            <div class="card" style="margin-top:10px">
                                                <form
                                                    action="{{ route('vendor.update.variation', $variable_product->id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="card-header row" id="headingThree">
                                                        <div class="col-md-11">
                                                            @foreach ($product_attributes as $product_attribute)
                                  
                                                                <?php
                                                                $name = $product_attribute->name;
                                                                $csk = $variable_product->variations->$name ?? false;
                                                                ?>
                                                                <select class="border" name="variation[{{ $product_attribute->name }}]"
                                                                    id="">
                                                                    @foreach ($product_attribute->value as $value)
                                                                 
                                                                        <option value="{{ $value }}" {{$value ==$csk ? 'selected' : ''}} >{{ $value }}
                                                                      
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            @endforeach
                                                        </div>
                                                        <div class="col-md-1" style="cursor: pointer;"
                                                            data-toggle="collapse"
                                                            data-target="#variable_collaps{{ $variable_product->id }}"
                                                            aria-expanded="false" aria-controls="variable_collaps">
                                                            <p> <i class="fas fa-sort-down"></i></p>
                                                        </div>
                                                    </div>
                                                    <div id="variable_collaps{{ $variable_product->id }}"
                                                        class="collapse" aria-labelledby="headingThree"
                                                        data-parent="#accordion">
                                                        <div class="card-body row">
                                                            <div class="form-group  col-md-4 ">
                                                                <label class="control-label"
                                                                    for="variable_price">Price</label>
                                                                <input type="number"min="1" max="50000"
                                                                    step="any" class="form-control"
                                                                    name="variable_price" placeholder="Price"
                                                                    id="variable_price"
                                                                    value="{{ $variable_product->price }}" required>
                                                            </div>
                                                            <div class="form-group  col-md-4 ">
                                                                <label class="control-label" for="variable_price">Sale
                                                                    Price</label>
                                                                <input type="number" min="1" max="50000"
                                                                    step="any" class="form-control" name="sale_price"
                                                                    placeholder="Sale Price" id="variable_price"
                                                                    value="{{ $variable_product->sale_price }}">
                                                            </div>
                                                            <div class="form-group  col-md-4 ">
                                                                <label class="control-label"
                                                                    for="variable_stock">Instock</label>
                                                                <input type="number" min="1" max="50000"
                                                                    step="any" class="form-control"
                                                                    name="variable_stock" placeholder="stock"
                                                                    id="variable_stock"
                                                                    value="{{ $variable_product->quantity }}">
                                                            </div>
                                                            <div class="form-group  col-md-4 ">
                                                                <label class="control-label"
                                                                    for="variable_sku">Sku</label>
                                                                <input type="text" class="form-control"
                                                                    name="variable_sku" placeholder="sku"
                                                                    id="variable_sku"
                                                                    value="{{ $variable_product->sku }}">
                                                            </div>
                                                            <div class="form-group  col-md-4 ">
                                                                <label class="control-label" for="image">Image</label>
                                                                <input type="file" class="form-control" name="image"
                                                                    style="padding: 6px 12px">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <img src="{{ Voyager::image($variable_product->image) }}"
                                                                    style="width:100px">
                                                            </div>
                                                            <div class="form-group  col-md-12 mt-2">
                                                                <button class="btn btn-primary"
                                                                    type="submit">Save</button>
                                                                <a href="{{ route('vendor.delete.product.meta', $variable_product->id) }}"
                                                                    class="btn btn-danger"
                                                                    onclick="cskDelete()">Delete</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endforeach
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif --}}
    </div>

    </div>
    </div>
    </section>
    <!-- End Vendor upload section -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script>
        $(document).ready(function() {
            document.getElementById('price')

            $('#salePrice, #price').blur(function() {
                // sale price calculation 
                var salePrice = $('#salePrice').val();
                var newSalePrice = parseFloat(salePrice);
                var salePricePercentageWithTen = (newSalePrice) * .1;
                var salePricePercentageWithsix = (newSalePrice) * .06;

                // price calculation 
                var price = $('#price').val();
                var newPrice = parseFloat(price);
                var pricePercentageWithTen = (newPrice) * .1;
                var pricePercentageWithsix = (newPrice) * .06;
                console.log(salePricePercentageWithTen);



                if (salePrice > 0) {


                    if (salePrice < 1000) {
                        var vendorPrice = newSalePrice - pricePercentageWithTen;
                        $('#priceMassage').text('Platform will receive' + ' 10% of ' + salePrice +
                            ', equaling ' + parseFloat(salePricePercentageWithTen).toFixed(2) +
                            ', and you will receive ' + (newSalePrice - salePricePercentageWithTen) +
                            '.');
                        $('#vendorPrice').val(vendorPrice);

                    } else {
                        vendorPrice = newSalePrice - salePricePercentageWithsix;
                        $('#priceMassage').text('Platform will receive' + ' 6% of ' + salePrice +
                            ', equaling ' + parseFloat(salePricePercentageWithsix).toFixed(2) +
                            ', and you will receive ' + (newSalePrice - salePricePercentageWithsix) +
                            '.');
                        $('#vendorPrice').val(vendorPrice);
                    }
                    $('#salePriceMassage').text('You offered a ' + parseFloat((price - salePrice) / price *
                        100).toFixed(2) + '% discount.')

                    console.log((price - salePrice) / price * 100);
                } else {


                    if (price < 1000) {
                        var vendorPrice = newPrice - pricePercentageWithTen;
                        $('#priceMassage').text('Platform will receive' + ' 10% of ' + price +
                            ', equaling ' + parseFloat(pricePercentageWithTen).toFixed(2) +
                            ', and you will receive ' + (newPrice - pricePercentageWithTen) + '.');
                        $('#vendorPrice').val(vendorPrice);
                    } else {
                        var vendorPrice = newPrice + pricePercentageWithsix;
                        $('#priceMassage').text('Platform will receive' + ' 10% of ' + price +
                            ', equaling ' + parseFloat(pricePercentageWithsix).toFixed(2) +
                            ', and you will receive ' + (newPrice - pricePercentageWithsix) + '.');
                        $('#vendorPrice').val(vendorPrice);
                    }
                }


            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            function toggleElements() {
                if ($('#variableCheck').prop('checked')) {
                    $('#variableFileds').show();
                } else {
                    $('#variableFileds').hide();
                }
            }
            toggleElements();
            $('#variableCheck').on('propertychange change click keyup input paste', function() {
                toggleElements();
            });
        });
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
