<div class="def-container">
    <div class="inner-def">
        <div class="def-content endless-pagination" data-next-page="{{$imagePosts->nextPageUrl()}}">
            @if(count($imagePosts)>0)
                @foreach($imagePosts as $imagePost)
                    @if($imagePost->title=='')
                        @continue
                    @else
                        <div class="d-none">{{$n++}}</div>
                        <div class="outer-word-display shadow rounded">
                            <a class="word-link"
                               href="/postImage/comment/{{$imagePost->id}}">{{$imagePost->title}}</a>

                            @if(Auth::check())
                                <div class="currentId d-none">{{Auth::user()->id}}</div>

                                @foreach($imagePost->allLike as $user)
                                    @if($user->user_id === Auth::user()->id)
                                        <div class="currentLike d-none">{{$user->like}}</div>
                                    @else
                                        <div class="currentLike d-none">0</div>
                                    @endif
                                @endforeach
                            @endif

                            @if(Auth::check() && Auth::user()->id == $imagePost->user_id)
                                <div class="word-icon">

                                    <i class="fas fa-edit imageEdit" data-toggle="modal"
                                       data-target="#editing" id="{{$imagePost->id}}"></i>
                                    <i class="fas fa-trash-alt imageDel" data-toggle="modal"
                                       data-target="#confirmModal" id="delThis{{$imagePost->id}}"></i>
                                </div>
                            @else
                                <div class="word-icon">

                                    <i class="fas" data-toggle="modal"
                                       data-target="#editModal"></i>
                                    <i class="fas"></i>
                                </div>
                            @endif
                            <div class="anchor-def">
                                <div class="search-cover">
                                    <img class="postImg" src="{{$imagePost->update_image}}" alt="">
                                </div>
                                <div class="post-content">
                                    <div class="post-text">{{$imagePost->description}}</div>

                                    <div class="post-div-btn">
                                        <div class="like-name-comment">
                                            <div class="like-comment">
                                                <div class="like-section">
                                                    <span class="sumLike">{{$imagePost->sumLike}}</span><i>&nbsp</i>
                                                    <i class="fas fa-heart"></i></div>
                                                <a class="comment-tag"
                                                   href="/postImage/comment/{{$imagePost->id}}">{{$imagePost->sumComment}}
                                                    &nbsp comments</a>
                                            </div>
                                            <div class="user-info">
                                                <div class="post-name">{{$imagePost->user[0]->name}}</div>
                                                <div class="user-img">
                                                    <img src="{{$imagePost->user[0]->user_image}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="infor-comment-like">
                                            <div class="like-count"></div>
                                            <div class="comment-count"></div>
                                        </div>
                                    </div>

                                    <div class="img-post-btn">
                                        <div class="like-btn" id="id-like-btn{{$n}}">
                                            <i class="fas fa-heart"> like &nbsp;</i>
                                        </div>

                                        <button class="button-comment" type="button"
                                                onclick="location.href='/postImage/comment/{{$imagePost->id}}'">
                                            <i class="fas fa-comment"></i> comment
                                        </button>

                                        <span
                                            class="timeCount">{{Carbon\Carbon::parse($imagePost->created_at)->diffForHumans()}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        @include('postImages.modal-delete-imagePost')
        @include('postImages.editing')
    </div>
</div>
@include('inc.spinner')
