@extends('layouts.app')
@section('content')

    <!-- Header Banner -->
    <div class="banner-header section-padding valign bg-img bg-fixed" data-overlay-dark="4" data-background="{{asset('assets/frontend-assets/img/slider/1.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-left caption mt-90">
                    <h5><a href="{{route('posts')}}">{{ __('words.news') }}</a> / {{$post->title}}</h5>
                    <h1>{{$post->title}}</h1>
                    <div class="post">
                        {{-- <div class="author"> <img src="{{asset('assets/frontend-assets/img/team/5.jpg')}}" alt="" class="avatar"> <span>Emma Emily</span> </div> --}}
                        <div class="date-comment"> <i class="ti-calendar"></i> {{$post->created_at->format('m D Y')}} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Post -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8"> 
                    <img src="{{Voyager::image($post->image)}}" class="mb-30" alt="">
                    <h2>{{$post->title}}</h2>
                      {!! $post->body !!}
                    {{-- <div class="post-comment-section">
                        <div class="row">
                            <!-- Comment -->
                            <div class="col-md-12">
                                <div class="news-post-comment-wrap">
                                    <div class="post-user-comment"> <img src="{{asset('assets/frontend-assets/img/team/3.jpg')}}" alt=""> </div>
                                    <div class="post-user-content">
                                        <span>
                                            <i class="star-rating"></i>
                                            <i class="star-rating"></i>
                                            <i class="star-rating"></i>
                                            <i class="star-rating"></i>
                                            <i class="star-rating"></i>
                                        </span>
                                        <h3>Robert Martin<span> 29 October 2022</span></h3>
                                        <p>Restaurant ultricies nibh non dolor maximus sceleue inte molliser rana neque nec tempor. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p> <a class="post-repay" href="#">Reply<i class="ti-back-left"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 mb-30">
                                <h3 class="mb-30">Leave a Reply</h3>
                                <form method="post" class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="name" id="name" placeholder="Full Name *" required="">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" name="email" id="email" placeholder="Email Address *" required="">
                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="message" id="message" cols="40" rows="4" placeholder="Your Comment *" required=""></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="butn-dark2"><span>Send Comment</span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="news2-sidebar row">
                        <div class="col-md-12">
                            <div class="widget search">
                                <form action="{{route('posts')}}">
                                    <input type="text" name="search" placeholder="{{ __('words.type_here') }}">
                                    <button type="submit"><i class="ti-search" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-title">
                                    <h6>{{ __('words.recent_posts') }}</h6>
                                </div>
                                <ul class="recent">
                                    @foreach ($recentPosts as $item)
                                        
                                    <li>
                                        <div class="thum"> <img src="{{Voyager::image($item->image)}}" alt=""> </div> 
                                        <a href="{{route('post',$post->slug)}}">{{$item->title}}</a>
                                    </li>
                                    @endforeach
                            
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-title">
                                    <h6>Archives</h6>
                                </div>
                                <ul>
                                    <li><a href="#">December 2022</a></li>
                                    <li><a href="#">November 2022</a></li>
                                    <li><a href="#">October 2022</a></li>
                                </ul>
                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-title">
                                    <h6>{{ __('words.categories') }}</h6>
                                </div>
                                <ul>
                                    @foreach ($categories as $category)
                                        
                                    <li><a href="{{route('posts',['category'=>$category->slug])}}"><i class="ti-angle-right"></i>{{$category->name}}</a></li>
                                    @endforeach
                                   
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="widget">
                                <div class="widget-title">
                                    <h6>Tags</h6>
                                </div>
                                <ul class="tags">
                                    <li><a href="#">Restaurant</a></li>
                                    <li><a href="#">Hotel</a></li>
                                    <li><a href="#">Spa</a></li>
                                    <li><a href="#">Health Club</a></li>
                                    <li><a href="#">Luxury Hotel</a></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->

@endsection