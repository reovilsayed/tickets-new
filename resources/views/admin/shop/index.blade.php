@extends('voyager::master')

@section('page_title', 'Shop Index' )



@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
          
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row" style="">
                            <div class="col-md-4">
                                <h3 class="" style="margin-bottom: 20px"> 
                                    Shops
                                </h3>
                            </div>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-2 " >
                                <a href="{{route('admin.shop.create')}}" class="btn btn-primary" style="width: 100%">Create</a>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>


                                        <th>
                                            User name

                                        </th>
                                        <th>
                                            Email

                                        </th>
                                        <th>
                                            Shop name

                                        </th>
                                        <th>
                                            logo
                                        </th>
                                        <th>Address</th>

                                        <th class="actions text-right dt-not-orderable">{{ __('voyager::generic.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($shops as $shop)
                                        <tr>
                                            <td>
                                                {{$shop->user ? $shop->user->name :''}}
                                            </td>
                                            <td>
                                                {{$shop->user ? $shop->user->email :''}}
                                            </td>
                                            <td>
                                                {{$shop->name}}
                                            </td>
                                            <td>
                                                <img src="{{Voyager::image($shop->logo)}}" alt="" height="60">
                                            </td>
                                            <td>
                                                {{$shop->city}},{{$shop->state}}, <br> {{$shop->country}}
                                            </td>
                                    
                                            
                                          
                                         
                                         
                                         
                                            <td class="no-sort no-click bread-actions">
                                                <a href="{{route('admin.shop.active',$shop)}}" class="btn btn-dark">{{$shop->status==true ? 'Deactive' :'Active'}}</a>
                                                <a href="{{route('admin.shops.edit',$shop)}}" class="btn btn-primary">Edit</a>
                                                <form action="{{route('admin.shops.delete',$shop)}}" method="post" style="display: inline">
                                                  @csrf
                                                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure delete this item ?');">Delete</button>

                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop

