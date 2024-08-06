<div class="ec-vendor-dashboard-card space-bottom-30">
    <div class="ec-vendor-card-header">
        <h5>Latest Products</h5>
        {{-- <div class="ec-header-btn">
            <a class="butn-dark2" href="{{ route('vendor.create.product') }}"><span>Create Product</span></a>
        </div> --}}

    </div>
    <form action="" method="get">
        <div class="row mt-2 justify-content-end me-3">
            <div class="form-group mb-3 col-md-6 d-flex">
                <input type="text" name="product_search" class="" placeholder="Search product">
                <div class="input-group-append">
                    <button type="submit" class="btn border btn-dark me-3" id="basic-addon2">Search</button>
                </div>
            </div>
        </div>
    </form>
    @if (count($products) == !0)
        <div class="ec-vendor-card-body">

            <div class="ec-vendor-card-table">



                <table class="table ec-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Categories</th>
                            <th scope="col">Status</th>
                            <th scope="col">Price</th>
                            {{-- <th scope="col">Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th scope="row"><span>{{ $loop->index + 1 }}</span></th>
                                <td> <a href="{{ route('product_details', $product->slug) }}"><img class="prod-img"
                                            src="{{ Voyager::image($product->image) }}" alt="product image"></a></td>
                                <td><a
                                        href="{{ route('product_details', $product->slug) }}"><span>{{ $product->name }}</span></a>
                                </td>
                                <td>
                                    @foreach ($product->prodcats as $prodcat)
                                        <span class="d-inline p-0"> {{ $prodcat->name }} ,</span>
                                    @endforeach

                                </td>
                                <td><span>{{ $product->status == 0 ? 'Pending' : 'Active' }}</span></td>
                                <td><span>{{ Sohoj::price($product->sale_price ?? $product->price) }}</span></td>
                                <td>
                                    {{-- <a class="btn btn-primary"
                                        href="{{ route('vendor.product.edit', $product->slug) }}"><i
                                            class="fa-solid fa-pen-to-square"></i></a> --}}
                                    {{-- <button type="submit" class="btn btn-warning"><i class="fa-solid fa-trash"></i></button> --}}
                                    {{-- <x-delete route="{{ route('vendor.products.delete', $product->id) }}" /> --}}

                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>

            </div>

        </div>
    @else
        <h3 class="text-center text-danger">{{ __('words.no_item_found') }}</h3>
    @endif
</div>
