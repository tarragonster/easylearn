@if(count($linkLists)>0)
    @foreach($linkLists as $linkList)
        <div class="outer-word-display public-box shadow rounded">
            <div class="top-part">
                <div class="inner-creater">
                    <div class="creator-info">
                        <div class="user-pic">
                            <img src="{{$linkList->user->user_image}}" alt="">
                        </div>
                        <div class="not-pic">
                            <div class="user-name">
                                <span>{{$linkList->user->name}}</span>
                            </div>
                            <div class="info-display">
                                <span>shared a </span>
                                <a href="{{$linkList->link}}">word list</a>
                                <div
                                    class="time-count">{{Carbon\Carbon::parse($linkList->updated_at)->diffForHumans()}}</div>
                                <div class="word-count">
                                    <span>Word count: </span>
                                    <span>{{$linkList->search->count()}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ddOption">
                        <i class="fas fa-ellipsis-v delTitle"
                           id="dropdownMenuButton{{$linkList->id}}" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="true"></i>

                        <div class="dropdown-menu dropdown-menu-right elipsisBtn"
                             aria-labelledby="dropdownMenuButton">

                            @if(Auth::check() && Auth::user()->id == $linkList->user_id)
                                <span class="delDropdown dropdown-item" data-toggle="modal"
                                      data-target="#publicDelModal">Delete</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="interact-list">

                </div>
            </div>

            <div class="lower-part">
                <div class="inner-creater">
                    <div class="access-link">
                        <a href="{{$linkList->link}}">{{$linkList->list_name}}</a>
                    </div>
                    <div class="review-word">

                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
