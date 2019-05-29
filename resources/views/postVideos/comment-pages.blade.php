@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" href="{{asset('css/search.css')}}" type="text/css">
@endsection

@section('content')
    <div class="top-container">
        <div class="search-container">
            <p class="heading-title shadow">Articles</p>
            <div class="heading shadow rounded">
                <div class="inner-heading">
                    <h4 id="display">{{$videoPost->user[0]->name}}'s Article</h4>

                </div>
                {{--<hr>--}}
            </div>
        </div>
        <div class="heading searching shadow rounded">
            <div class="inner-heading search-bar">
                {!! Form::open(['action'=>'DictionariesController@search','method'=>'GET','class'=>'search-form']) !!}

                <div class="input-group">

                    {{Form::text('q',$q,['class'=>'form','placeholder'=>'Search'])}}

                    {{Form::select('language', ['E' => 'English', 'K' => 'Korean'],$selectOption,['class'=>'btn-select dropdown-toggle'])}}

                    {{Form::button('<i class="fas fa-search"></i>',['class'=>'btn-search','type'=>'submit'])}}

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="outer-def-container shadow rounded">
        <div class="def-container">
            <div class="inner-def">
                <div class="def-content">

                    <div class="d-none">{{$n++}}</div>
                    <div class="outer-word-display shadow rounded">
                        <a class="word-link"
                           href="/postVideo/comment/{{$videoPost->id}}"
                           style="pointer-events: none;">{{$videoPost->title}}</a>

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

                                <i class="fas fa-edit" data-toggle="modal"
                                   data-target="#editVid{{$n}}"></i>
                                <i class="fas fa-trash-alt"></i>
                            </div>
                        @else
                            <div class="word-icon">

                                <i class="fas" data-toggle="modal"
                                   data-target="#editModal{{$n}}"></i>
                                <i class="fas"></i>
                            </div>
                        @endif
                        <div class="anchor-def">
                            <div class="search-cover">
                                <div>
                                    <div class="disVid d-none">{{$videoPost->video}}</div>
                                </div>
                                <button type="button" class="btn btn-info shade" data-toggle="modal"
                                        data-target="#modalYT{{$n}}"></button>
                            </div>
                            <div class="post-content">
                                <div class="post-text">{{$videoPost->description}}</div>

                                <div class="post-div-btn">
                                    <div class="like-name-comment">
                                        <div class="like-comment">
                                            <div class="like-section">{{$videoPost->sumLike}} <i
                                                    class="fas fa-heart"></i></div>
                                            <a class="comment-tag" href="/postVideo/comment/{{$videoPost->id}}"
                                               style="pointer-events: none;">{{$videoPost->sumComment}} comments</a>
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

                                    <button class="button-comment" type="button" style="pointer-events: none;"
                                            onclick="location.href='/postVideo/comment/{{$videoPost->id}}'">
                                        <i class="fas fa-comment"></i> comment
                                    </button>

                                    <span
                                        class="timeCount">{{Carbon\Carbon::parse($videoPost->created_at)->diffForHumans()}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="anchor-def">
                            <div class="comment-section">
                                <p class="comment-desc">Comment Section</p>
                                @if(Auth::check())
                                    <div class="outer-comment">
                                        <div class="user-ava">
                                            <div class="img-container">
                                                <img src="{{Auth::user()->user_image}}" alt="">
                                            </div>
                                        </div>
                                        <div class="input-section">
                                            <form action="{{action('PostVideoController@inputComment')}}"
                                                  method="POST"
                                                  class="comment-form">
                                                <input type="hidden" name="_token"
                                                       value="<?php echo csrf_token(); ?>">
                                                <div contenteditable="true" class="input-field"></div>
                                                <div class="user_id d-none">{{Auth::user()->id}}</div>
                                                <div class="post_id d-none">{{$videoPost->id}}</div>
                                                <div class="button-save-comment">
                                                    <input type="submit" class="save-comment"
                                                           value="COMMENT">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                                <div class="outer-comment display-comment">

                                </div>
                            </div>
                        </div>
                        @include('postVideos.displayVid')
                        @include('postVideos.editing')
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="prompt-msg"></div>

    <script>
        var postId = $('.word-link').attr('href').substr(19);

        $(document).ready(function () {

            convertHTML()

            // displayCommentNum()

            postCommentContent();

            postingVid()

            $('.currentLike').each(function () {

                if ($(this).text() === '1') {

                    var outerDiv = $(this).parent();

                    var likeButton = outerDiv.find('.like-btn');

                    likeButton.css('color', '#BB9A81');
                    likeButton.css('background-color', '#49463D');

                    likeButton.hover(function () {
                        likeButton.css('color', '#BB9A81');
                        likeButton.css('background-color', '#49463D')
                    }, function () {
                        likeButton.css('color', '#BB9A81');
                        likeButton.css('background-color', '#49463D')
                    })

                }
            })
        });

        function convertHTML() {
            $('.disVid').each(function () {
                var anchor = $(this).parent();
                anchor.html($(this).text())
            })
        }

        function displayCommentNum() {

            $('.word-link').each(function () {

                var post = {
                    id: $(this).attr('href').substr(19),

                    commentCount: function () {

                        return theCountVid(this.id)
                    },

                };

                console.log(post.commentCount())

                injectCommentCountVid($(this), post.commentCount())
            })
        }

        function theCountVid(id) {
            var theData;

            $.ajax({
                type: 'POST',
                url: "{{url('/postVideo/commentCount')}}",
                dataTy: 'json',
                data: {id: id},
                // async:false,
                success: function (data) {
                    theData = data
                },
                async: false,
            });

            return theData
        }

        function injectCommentCountVid(theLink, theCount) {

            var comment = theLink.parent().find('.comment-tag');

            comment.text(theCount + ' comments')
        }

        //Using postId to get row in comment table
        //if row existed get userId->name/image, row->comment

        function getPostComment() {
            var commentData;

            $.ajax({
                type: "POST",
                url: "{{url('/postVideo/commentGet')}}",
                data: {postId: postId},
                dataTy: 'json',
                async: false,
                success: function (data) {
                    commentData = data
                },
            });
            return commentData
        }

        function postCommentContent() {

            var anchor = $('.display-comment');

            var commentData = getPostComment();

            anchor.empty();

            $(commentData).each(function (index, value) {
                var user = value.user[0];
                var comment = value.comment;

                buildCommentContent(anchor, user, comment)
            })
        }

        function buildCommentContent(anchor, user, comment) {

            anchor.prepend($('<div class="user-part">' +
                '<div class="user-ava">' +
                '<div class="img-container">' +
                '<img src="' + user.user_image + '">' +
                '</div>' +
                '</div>' +
                '<div class="name-container">' +
                '<span class="userName">' + user.name + '</span>' +
                '<div class="comment-part">' + comment + '</div>' +
                '</div>' +
                '</div>'))

        }

        $('.fa-trash-alt').click(function () {
            var getId = $(this).parent().parent().find('.word-link').attr('href').substr(19);

            var outerDel = $(this).parent().parent();

            var delId = {getId: getId};

            $.ajax({
                type: "POST",
                url: "{{url('/postVideo/delete')}}",
                data: delId,
                dataTy: 'json',
                success: function (data) {
                    outerDel.remove();

                    $('.prompt-msg').empty();

                    $('.prompt-msg').append($('<span>Removed</span>')).show().delay(3000).fadeOut();

                },
            });

        });

        $('.like-btn').on('click', function () {

            var getDiv = $(this).parent().parent().parent().parent();

            var getId = getDiv.find('.word-link').attr('href').substr(19);

            var currentUserId = getDiv.find('.currentId').text();

            var likeButton = $(this);

            var likeId = {getId: getId, currentUserId: currentUserId};

            console.log(likeButton.css('color'));

            if (likeButton.css('color') !== 'rgb(187, 154, 129)') {

                $.ajax({
                    type: "POST",
                    url: "{{url('/postVideo/like')}}",
                    data: likeId,
                    dataTy: 'json',
                    success: function (data) {

                        console.log(data);

                        likeButton.css('color', '#BB9A81');
                        likeButton.css('background-color', '#49463D');

                        likeButton.hover(function () {
                            likeButton.css('color', '#BB9A81');
                            likeButton.css('background-color', '#49463D')
                        }, function () {
                            likeButton.css('color', '#BB9A81');
                            likeButton.css('background-color', '#49463D')
                        })
                    },
                });
            } else {

                $.ajax({
                    type: "POST",
                    url: "{{url('/postVideo/reverseLike')}}",
                    data: likeId,
                    dataTy: 'json',
                    success: function (data) {

                        console.log(data);

                        likeButton.css('color', '#49463D');
                        likeButton.css('background-color', '#A39F8B');

                        likeButton.hover(function () {
                            likeButton.css('color', '#D1CBB3');
                            likeButton.css('background-color', '#49463D');
                        }, function () {
                            likeButton.css('color', '#49463D');
                            likeButton.css('background-color', '#A39F8B');
                        })

                    },
                });
            }

            var likeSection = getDiv.find('.like-section');

            $.ajax({
                type: "POST",
                url: "{{url('/postVideo/getLike')}}",
                data: likeId,
                dataTy: 'json',
                success: function (data) {

                    likeSection.text(data).append('<i>&nbsp;</i>').append($('<i class="fas fa-heart"></i>'))

                },
            });

        });

        function postingVid() {
            $('.comment-form').on('submit', function (e) {
                e.preventDefault();

                var url = $(this).attr('action');
                var post = $(this).attr('method');

                var postId = $(this).find('.post_id').text();
                var userId = $(this).find('.user_id').text();
                var comment = $(this).find('.input-field').text();

                var data = {postId: postId, userId: userId, comment: comment};

                if (comment === '') {
                    return false
                } else {
                    $.ajax({
                        type: post,
                        url: url,
                        data: data,
                        dataTy: 'json',
                        success: function (data) {
                            $('.input-field').empty();

                            postCommentContent()

                            displayCommentNum()
                        },
                    });
                }
            })
        }

    </script>
@endsection
