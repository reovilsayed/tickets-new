

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', 'Hotel Owner Edit')

@section('page_header')

    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <h3>Edit {{$shop->name}} </h3>
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered " style="padding: 10px">
                 <form action="{{route('admin.shops.update',$shop)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('admin.shop.includes.form')
                 </form>

           
                </div>
            </div>
        </div>
    </div>


@stop

