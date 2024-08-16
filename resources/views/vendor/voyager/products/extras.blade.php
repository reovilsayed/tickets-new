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
                            Add Extras
                        </h3>
                        <hr>
                        <form action="{{ route('voyager.products.add-extras', $product) }}" method="post">
                            @csrf
                            <div class="row">
                                @foreach ($extras as $extra)
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">{{ $extra->name }}</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><input
                                                        name="extras[{{ $extra->id }}][checked]" value="1"
                                                        type="checkbox" @if (array_key_exists($extra->id, $product->extras)) checked @endif></span>
                                                <input id="email" type="number" class="form-control"
                                                    value="{{ @$product->extras[$extra->id] ?? 0 }}" min="0" 
                                                    name="extras[{{ $extra->id }}][qty]" name="{{ $extra->name }}"
                                                    placeholder="{{$extra->name}}'s qty">
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
