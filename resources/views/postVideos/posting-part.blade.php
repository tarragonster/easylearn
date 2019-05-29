<div class="def-container">
    <div class="inner-def">
        <div class="def-content endless-pagination" data-next-page = "{{$videoPosts->nextPageUrl()}}">
            @if(count($videoPosts)>0)
                @foreach($videoPosts as $videoPost)
                    @if($videoPost->title=='')
                        @continue
                    @else
                        <div class="d-none">{{$n++}}</div>
                        <div class="outer-word-display shadow rounded">
                            <a class="word-link"
                               href="/postVideo/comment/{{$videoPost->id}}">{{$videoPost->title}}</a>

                            @if(Auth::check())
                                <div class="currentId d-none">{{Auth::user()->id}}</div>

                                @foreach($videoPost->allLike as $user)
                                    @if($user->user_id === Auth::user()->id)
                                        <div class="currentLike d-none">{{$user->like}}</div>
                                    @else
                                        <div class="currentLike d-none">0</div>
                                    @endif
                                @endforeach
                            @endif

                            @if(Auth::check() && Auth::user()->id == $videoPost->user_id)
                                <div class="word-icon">

                                    <i class="fas fa-edit videoEdit" data-toggle="modal"
                                       data-target="#editVid" id="{{$videoPost->id}}"></i>
                                    <i class="fas fa-trash-alt" data-toggle="modal" data-target="#confirmModal{{$n}}"></i>
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
                                    <div>
                                        <div class="disVid d-none">{{$videoPost->video}}</div>
                                    </div>
                                    <button type="button" class="btn btn-info shade showVidModal" data-toggle="modal"
                                            data-target="#modalYT" id="popup{{$videoPost->id}}"></button>
                                </div>
                                <div class="post-content">
                                    <div class="post-text">{{$videoPost->description}}</div>

                                    <div class="post-div-btn">
                                        <div class="like-name-comment">
                                            <div class="like-comment">
                                                <div class="like-section">{{$videoPost->sumLike}} <i
                                                        class="fas fa-heart"></i></div>
                                                <a class="comment-tag" href="/postVideo/comment/{{$videoPost->id}}">{{$videoPost->sumComment}} comments</a>
                                            </div>
                                            <div class="user-info">
                                                <div class="post-name">{{$videoPost->user[0]->name}}</div>
                                                <div class="user-img">
                                                    <img src="{{$videoPost->user[0]->user_image}}" alt="">
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
                                                onclick="location.href='/postVideo/comment/{{$videoPost->id}}'">
                                            <i class="fas fa-comment"></i> comment
                                        </button>

                                        <span
                                            class="timeCount">{{Carbon\Carbon::parse($videoPost->created_at)->diffForHumans()}}</span>
                                    </div>
                                </div>
                            </div>
                            @include('postVideos.modal-delete-vidPost')
                        </div>
                    @endif
                @endforeach
                    @include('postVideos.displayVid')
                    @include('postVideos.editing')
            @endif
        </div>
    </div>
</div>
