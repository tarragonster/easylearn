<div class="paginating-container">
    <div class="paginating-inner">
        @foreach($posts as $post)
            <div class="container-ele">

                <div class="word-link d-none">{{$post->id}}</div>
                @if(Auth::check())
                    <div class="currentId d-none">{{Auth::user()->id}}</div>

                    @foreach($post->allLike as $user)
                        @if($user->user_id === Auth::user()->id)
                            <div class="currentLike d-none">{{$user->like}}</div>
                        @else
                            <div class="currentLike d-none">0</div>
                        @endif
                    @endforeach
                @endif

                <div class="outer-ele">

                    <div class="grid-deco-ele">
                        <div class="art-ele">
                            <div class="image-div">
                                <a href="/postImage/comment/{{$post->id}}">
                                    <img class="img-inner" src="{{$post->update_image}}" alt="">
                                </a>
                            </div>
                            <div class="title-like-comment">
                                <div class="outer-tilte">
                                    <a class="title-desc" href="/postImage/comment/{{$post->id}}">{{$post->title}}</a>
                                </div>

                                <div class="date-comLike">
                                    <div class="comLike-section">
                                        <div class="getLike">
                                            <div class="like-section">{{$post->sumLike}}</div>
                                            <div class="like-btn">
                                                <i class="fas fa-heart"></i>
                                            </div>
                                        </div>
                                        <a class="comment-tag" href="/postImage/comment/{{$post->id}}">{{$post->sumComment}} comments</a>
                                    </div>

                                    <span class="timeCount">{{Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {!!$posts->links()!!}
</div>
