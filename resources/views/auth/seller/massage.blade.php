@extends('layouts.seller-dashboard')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/chat.css') }}">
@endsection
@section('dashboard-content')

    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="container bootstrap snippets bootdey my-5">
            <div class="tile tile-alt" id="messages-main">
                <div class="ms-menu">
                    <div class="ms-user clearfix">
                        <img src="{{asset('assets/img/User-avatar.png')}}" alt=""
                            class="img-avatar pull-left">
                        <div>Signed in as <br>{{ auth()->user()->shop->name }}</div>
                    </div>


                    <div class="list-group lg-alt mt-3" style="height: 70vh;overflow-x: auto;">


                        @foreach ($users as $u)
                            <a class="list-group-item media"
                                style="{{ $u->id == $user->id ? 'background-color: #EEEEEE;' : '' }}"
                                href="{{ route('vendor.massage', $u->id) }}">
                                <div class="pull-left">
                                    <img src="{{asset('assets/img/User-avatar.png')}}" alt=""
                                        class="img-avatar">
                                </div>
                                <div class="media-body">
                                    <small class="list-group-item-heading ms-2">{{ $u->name }}</small>

                                </div>
                            </a>
                        @endforeach


                    </div>


                </div>

                <div class="ms-body">
                    <div class="action-header clearfix">
                        <div class="visible-xs" id="ms-menu-trigger">
                            <i class="fa fa-bars"></i>
                        </div>

                        <div class="pull-left hidden-xs">
                            <img src="{{asset('assets/img/User-avatar.png')}}" alt=""
                                class="img-avatar m-r-10">
                            <div class="lv-avatar pull-left">

                            </div>
                            <span>{{ $user->name }}</span>
                        </div>

                    </div>
                    <div style="position:relative; ">
                        <div style="height: 70vh; overflow-x: auto;">

                            @if ($massages)
                                @foreach ($massages as $massage)
                                    @if ($massage->sender_id == auth()->user()->shop->id)
                                        <div class="message-feed media">
                                            <div class="pull-left">
                                                <img src="{{ auth()->user()->shop->logo ? Storage::url(auth()->user()->shop->logo) : 'https://bootdey.com/img/Content/avatar/avatar1.png' }}"
                                                    alt="" class="img-avatar">
                                            </div>
                                            <div class="media-body">
                                                <div class="mf-content"
                                                    style="
                        margin-left: 10px;
                    ">
                                                    {{ $massage->massage }}
                                                </div>
                                                <small class="mf-date"><i class="fa fa-clock-o"></i>
                                                    {{ $massage->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="message-feed right">
                                            <div class="pull-right">
                                                <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt=""
                                                    class="img-avatar">
                                            </div>
                                            <div class="media-body">
                                                <div class="mf-content">
                                                    {{ $massage->massage }}
                                                </div>
                                                <small class="mf-date"><i class="fa fa-clock-o"></i>
                                                    {{ $massage->created_at->diffForHumans() }}0</small>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif


                        </div>
                        @if ($user->id)
                            <form action="{{ route('vendor.massage.store', $user->id) }}">
                                <div class="msb-reply" style="position: absolute;width: 100%;bottom:0">
                                    <input type="text" style="border:none" placeholder="What's on your mind..." name="massage">
                                    <button type="submit"><i class="far fa-paper-plane"></i></button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function() {
            if ($('#ms-menu-trigger')[0]) {
                $('body').on('click', '#ms-menu-trigger', function() {
                    $('.ms-menu').toggleClass('toggled');
                });
            }
        });
    </script>
@endsection
