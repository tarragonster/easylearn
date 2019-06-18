@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" href="{{asset('css/search.css')}}" type="text/css">
@endsection

@section('content')
    <div class="top-container">
        <div class="search-container">
            <p class="heading-title shadow">Public</p>
            <div class="heading shadow rounded">
                <div class="inner-heading">
                    <h4 id="display">Public Lists</h4>

                </div>
                {{--<hr>--}}
            </div>
        </div>
        <div class="heading searching shadow rounded">
            <div class="inner-heading search-bar">
                {!! Form::open(['action'=>'DictionariesController@search','method'=>'GET','class'=>'search-form']) !!}

                <div class="input-group">

                    {{Form::text('q',$q,['class'=>'form','placeholder'=>'Search'])}}

                    {{Form::select('language', ['E' => 'English', 'K' => 'Korean', 'V' => 'Vi-En', 'J' => 'Japanese'],$selectOption,['class'=>'btn-select dropdown-toggle'])}}

                    {{Form::button('<i class="fas fa-search"></i>',['class'=>'btn-search','type'=>'submit'])}}

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="outer-def-container shadow rounded">
        <div class="def-container">
            <div class="inner-def">
                <div class="def-content endless-pagination" data-next-page="{{$linkLists->nextPageUrl()}}">
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
                                                        class="time-count">{{Carbon\Carbon::parse($linkList->created_at)->diffForHumans()}}</div>
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
                    @include('practices.modal-delete-public')
                </div>
            </div>
        </div>
        @include('inc.spinner')
    </div>
<script>
    $(document).ready(function () {

        $(window).scroll(fetchPosts);

    });

    var isScroll = true;

    function fetchPosts(){

        var page = $('.endless-pagination').data('next-page');

        if(page !== null){

            clearTimeout($.data(this,'scrollCheck'));

            $.data(this,'scrollCheck',setTimeout(function () {
                var scrollPositionForLoad = $(window).height() +$(window).scrollTop()+100;

                if(scrollPositionForLoad >= $(document).height()){

                    $('.loader').css('display','block');

                    if(isScroll == true){
                        isScroll = false;
                        $.get(page,function(data){

                            $('.def-content').append(data.public);
                            $('.endless-pagination').data('next-page',data.next_page);
                            isScroll=true;

                            $('.loader').css('display','none');
                        });
                    }
                }
            },350))
        }
    }
</script>
@endsection
