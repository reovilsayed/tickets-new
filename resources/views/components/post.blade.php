<div class="col-md-4 mb-30">
    <div class="item">
            <div class="position-re o-hidden"> <img src="{{Voyager::image($post->image)}}" alt="">
                <div class="date" style="background-color: #f3454f">
                    <a href="{{route('post',$post->slug)}}"> <span>{{$post->created_at->format('M')}}</span> <i>{{$post->created_at->format('d')}}</i> </a>
                </div>
            </div>
            <div class="con"> <span class="category">
                    <a href="{{route('posts',['category'=>$post->category->slug])}}">{{$post->category->name}}</a>
                </span>
                <h5><a href="{{route('post',$post->slug)}}">{{$post->title}}</a></h5>
            </div>
        </div>
</div>