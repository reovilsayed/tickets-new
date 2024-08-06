@extends('layouts.app')
@section('css')
    <style>
        .navbar .navbar-nav .nav-link {
            color: rgb(255, 255, 255);
        }

        p {
            color: white !important;
        }

        strong {
            color: #bd3d06 !important;
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
