@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop



@section('content')
    <div class="container">
        <div class="page-content edit-add">
            <h3>
                Generate physical tickets - {{ $product->name }}
            </h3>
            <div class="panel">
                <div class="panel-body">
                    <form action="{{ route('voyager.products.ticketCreatePhysical.post', $product) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <input type="number" min="1" max="{{ $product->quantity }}" class="form-control"
                                        id="qty" name="qty">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary"><i class="voyager-paper-plane"></i> Generate</button>
                    </form>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <th>
                                Name
                            </th>
                            <th>
                                Tickets
                            </th>
                            <th>
                                Action
                            </th>
                        </tr>
                        @foreach ($tickets as $group => $count)
                            <tr>
                                <td>
                                    {{ $group }}
                                </td>
                                <td>
                                    {{ $count }}
                                </td>
                                <td>
                                    <a class="btn btn-primary"
                                        href="{{ route('voyager.products.ticketCreatePhysical.download', ['product'=>$product,'group' => $group]) }}">
                                        <i class="voyager-download"></i> Excel</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- End Delete File Modal -->
@stop
