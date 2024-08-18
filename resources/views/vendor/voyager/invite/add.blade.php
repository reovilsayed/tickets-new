@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop



@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <h3>
                            Add product to invite link
                        </h3>
                        <hr>
                        <form action="{{ route('voyager.invites.store-product', $invite) }}" method="post">
                            @csrf
                            <div class="row">
                                @foreach ($products as $product)
                                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">{{ $product->name }}</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><input
                                                        name="product[{{ $product->id }}][checked]" value="1"
                                                        type="checkbox"
                                                        @if ($invite->products->contains($product)) checked @endif></span>
                                                <input id="email" type="number" class="form-control" min="1" value="{{$invite->products->find($product)?->pivot?->quantity}}"
                                                    min="0" name="product[{{ $product->id }}][qty]"
                                                    name="{{ $product->name }}" placeholder="{{ $product->name }}'s qty">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>


                </div>

            </div>
        </div>
    </div>
    </div>


    <!-- End Delete File Modal -->
@stop
