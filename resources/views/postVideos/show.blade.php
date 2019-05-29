@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" href="{{asset('css/search.css')}}" type="text/css">
@endsection

@section('content')
    <div class="top-container">
        <div class="search-container">
            <p class="heading-title shadow">Videos</p>
            <div class="heading shadow rounded">
                <div class="inner-heading">
                    <h4 id="display">Feature Videos</h4>

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
        @include('postVideos.posting-part')
    </div>

    <div class="prompt-msg"></div>

    <script>

        $(document).ready(function () {

            $(window).scroll(fetchPosts);

            convertHTML();

            checkCurrentLike();

            addLike()

            showVidModal()

            closeVidModal()

            // displayCommentNum()

        });

        function checkCurrentLike(){
            $('.currentLike').each(function () {

                console.log($(this).text());

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
        }

        function convertHTML(){

            $('.disVid').each(function () {
                var anchor = $(this).parent();
                anchor.html($(this).text())
            })
        }

        function displayCommentNum() {

            $('.word-link').each(function () {

                var post ={
                    id: $(this).attr('href').substr(19),

                    commentCount: function () {

                        return theCountVid(this.id)
                    },

                };

                injectCommentCountVid($(this),post.commentCount())
            })
        }

        function theCountVid(id){
            var theData;

            $.ajax({
                type: 'POST',
                url: "{{url('/postVideo/commentCount')}}",
                dataTy:'json',
                data: {id:id},
                success: function (data) {
                    theData = data
                },
                async:false,
            });

            return theData
        }

        function injectCommentCountVid(theLink,theCount){

            var comment = theLink.parent().find('.comment-tag');

            comment.text(theCount +' comments')
        }


        {{--$('.fa-trash-alt').click(function () {--}}
            {{--var getId = $(this).parent().parent().find('.word-link').attr('href').substr(19);--}}

            {{--var outerDel = $(this).parent().parent();--}}

            {{--var delId = {getId: getId};--}}

            {{--$.ajax({--}}
                {{--type: "POST",--}}
                {{--url: "{{url('/postVideo/delete')}}",--}}
                {{--data: delId,--}}
                {{--dataTy: 'json',--}}
                {{--success: function (data) {--}}
                    {{--outerDel.remove();--}}

                    {{--$('.prompt-msg').empty();--}}

                    {{--$('.prompt-msg').append($('<span>Removed</span>')).show().delay(3000).fadeOut();--}}

                {{--},--}}
            {{--});--}}

        {{--});--}}

        //    like button onclick per posts

        function addLike(){
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

            })
        }

        function showVidModal(){

            $('.showVidModal').on('click', function () {

                var theId = $(this).attr('id').substr(5);

                var anchor = $('#modalYT');

                $.ajax({
                    type: "POST",
                    url: "{{'/postVideo/restartModal'}}",
                    data: {id: theId},
                    dataTy: 'json',
                    async: false,
                    success: function (data) {

                        $.each(data, function (i, p) {

                            anchor.find('.anchor-iframe').html(p.video);

                        })
                    },
                })

            });

        }


    //    stop video after closing modal

        function closeVidModal(){

            $('.vidModal').on('hidden.bs.modal',function () {

                var modalIframe = $(this).find('.anchor-iframe').html();

                $(this).find('.embed-responsive').empty();

                $(this).find('.embed-responsive').append($('<div class="anchor-iframe"></div>').append($('<div class="inner-anchor-iframe"></div>').append($(modalIframe))))
            })

        }

        function fetchPosts(){

            var page = $('.endless-pagination').data('next-page');

            if(page !== null){

                clearTimeout($.data(this,'scrollCheck'));

                $.data(this,'scrollCheck',setTimeout(function () {
                    var scrollPositionForLoad = $(window).height() +$(window).scrollTop()+100;

                    if(scrollPositionForLoad >= $(document).height()){
                        $.get(page,function(data){

                            $('.def-content').append(data.videoPosts);
                            $('.endless-pagination').data('next-page',data.next_page);

                            convertHTML();

                            checkCurrentLike();

                            addLike();

                            showVidModal();

                            closeVidModal()
                        });
                    }
                },350))
            }
        }

    </script>

@endsection
