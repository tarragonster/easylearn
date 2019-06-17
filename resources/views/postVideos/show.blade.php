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
                {!! Form::open(['action'=>'PostVideoController@search','method'=>'GET','class'=>'search-form']) !!}

                <div class="input-group">

                    {{Form::text('q',$q,['class'=>'form','placeholder'=>'Search'])}}

                    <div class="search-info d-none">{{$q}}</div>

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

        // function addLike(){

            $(document).on('click','.like-btn', function () {

                var getDiv = $(this).parent().parent().parent().parent();

                var getId = getDiv.find('.word-link').attr('href').substr(19);

                var currentUserId = getDiv.find('.currentId').text();

                var likeButton = $(this);

                var likeSection = getDiv.find('.sumLike');

                var likeId = {getId: getId, currentUserId: currentUserId};

                console.log(likeButton.css('color'));

                if (likeButton.css('color') !== 'rgb(187, 154, 129)') {

                    $.ajax({
                        type: "POST",
                        url: "{{url('/postVideo/like')}}",
                        data: likeId,
                        dataTy: 'json',
                        success: function (data) {


                        },
                    });

                    likeButton.css('color', '#BB9A81');
                    likeButton.css('background-color', '#49463D');

                    likeButton.hover(function () {
                        likeButton.css('color', '#BB9A81');
                        likeButton.css('background-color', '#49463D')
                    }, function () {
                        likeButton.css('color', '#BB9A81');
                        likeButton.css('background-color', '#49463D')
                    })

                    likeSection.text(parseInt(likeSection.text()) + 1)

                } else {

                    $.ajax({
                        type: "POST",
                        url: "{{url('/postVideo/reverseLike')}}",
                        data: likeId,
                        dataTy: 'json',
                        success: function (data) {

                            console.log(data);

                        },
                    });

                    likeButton.css('color', '#49463D');
                    likeButton.css('background-color', '#A39F8B');

                    likeButton.hover(function () {
                        likeButton.css('color', '#D1CBB3');
                        likeButton.css('background-color', '#49463D');
                    }, function () {
                        likeButton.css('color', '#49463D');
                        likeButton.css('background-color', '#A39F8B');
                    });

                    likeSection.text(parseInt(likeSection.text()) - 1)

                }

                {{--$.ajax({--}}
                    {{--type: "POST",--}}
                    {{--url: "{{url('/postVideo/getLike')}}",--}}
                    {{--data: likeId,--}}
                    {{--dataTy: 'json',--}}
                    {{--success: function (data) {--}}

                        {{--likeSection.text(data).append('<i>&nbsp;</i>').append($('<i class="fas fa-heart"></i>'))--}}

                    {{--},--}}
                {{--});--}}

            });
        // }

        // function showVidModal(){

            $(document).on('click','.showVidModal', function () {

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

        // }


    //    stop video after closing modal

        // function closeVidModal(){

            $(document).on('hidden.bs.modal','.vidModal',function () {

                var modalIframe = $(this).find('.anchor-iframe').html();

                $(this).find('.embed-responsive').empty();

                $(this).find('.embed-responsive').append($('<div class="anchor-iframe"></div>').append($('<div class="inner-anchor-iframe"></div>').append($(modalIframe))))
            });

        // }

        var isScroll = true;
        function fetchPosts(){

            var page = $('.endless-pagination').data('next-page');

            if(page !== null && page !== ''){

                clearTimeout($.data(this,'scrollCheck'));

                $.data(this,'scrollCheck',setTimeout(function () {
                    var scrollPositionForLoad = $(window).height() +$(window).scrollTop()+100;

                    if(scrollPositionForLoad >= $(document).height()){

                        $('.loader').css('display','block');

                        if(isScroll == true){
                            isScroll = false;
                            if (window.location.pathname === "/postVideo/search") {

                                var searchInfo = $('.search-info').text();

                                $.ajax({
                                    type: 'GET',
                                    url: page,
                                    dataTy:'json',
                                    data: {searchInfo:searchInfo},
                                    async:false,
                                    success: function (data) {

                                        $('.def-content').append(data.videoPosts);
                                        $('.endless-pagination').data('next-page',data.next_page);

                                        isScroll=true;

                                        $('.loader').css('display','none');

                                        convertHTML();

                                        checkCurrentLike();
                                    }
                                });

                            }else{

                                $.get(page,function(data){

                                    $('.def-content').append(data.videoPosts);
                                    $('.endless-pagination').data('next-page',data.next_page);

                                    isScroll=true;

                                    $('.loader').css('display','none');

                                    convertHTML();

                                    checkCurrentLike();


                                });

                            }
                        }
                    }
                },350))
            }
        }

    </script>

@endsection
