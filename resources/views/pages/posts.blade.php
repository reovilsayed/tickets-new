@extends('layouts.app')
@section('content')
    <!-- Header Banner -->
    <div class="banner-header section-padding valign bg-img bg-fixed" data-overlay-dark="4" data-background="{{asset('assets/frontend-assets/img/slider/5.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-left caption mt-90">
                    <h5>{{__('words.news_hero_subtittle')}}</h5>
                    <h1>{{__('words.news_hero_tittle')}}</h1>
                </div>
            </div>
        </div>
    </div>
    <!-- News  -->
<section class="news section-padding bg-blck pt-5">
    <div class="container">
        <div class="row">
            @foreach ($posts as $post)
                
            <x-post :post="$post"/>
            @endforeach
      
        </div>
        {{$posts->links()}}

    </div>
</section>
@endsection