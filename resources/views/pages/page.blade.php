@extends('layouts.app')
@section('css')
    <style>
        .navbar .navbar-nav .nav-link {
            color: black;
        }
    </style>
@endsection
@section('content')
@section('title', $page->title)

<div class="container py-5" style="padding-top: 10rem !important;">
    <h1>
        {{ $page->title }}
    </h1>
    <div class="page-content__wrap">
        {!! $page->body !!}
    </div>
</div>

@endsection
