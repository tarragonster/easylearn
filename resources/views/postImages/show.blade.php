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
                    <h4 id="display">Feature Articles</h4>

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
        @include('postImages.posting-part')
    </div>

    <div class="prompt-msg"></div>

    <script>

        $(document).ready(function () {

            // displayCommentCount()

            // addLike();

            $(window).scroll(fetchPosts);

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

        function displayCommentCount() {

            $('.word-link').each(function () {

                var post ={
                    id: $(this).attr('href').substr(19),

                    commentCount: function () {

                        return theCount(this.id)
                    },

                };

                injectCommentCount($(this),post.commentCount())
            })
        }

        function theCount(id){
            var theData;

            $.ajax({
                type: 'POST',
                url: "{{url('/postImage/commentCount')}}",
                dataTy:'json',
                data: {id:id},
                async:false,
                success: function (data) {
                    theData = data
                }
            });

            return theData
        }

        function injectCommentCount(theLink,theCount){

            var comment = theLink.parent().find('.comment-tag');

            comment.text(theCount +' comments')
        }

        //    like button onclick per posts

        // function addLike(){

            $(document).on('click','.like-btn' ,function () {

                var getDiv = $(this).parent().parent().parent().parent();

                var getId = getDiv.find('.word-link').attr('href').substr(19);

                var currentUserId = getDiv.find('.currentId').text();

                var likeButton = $(this);

                var likeSection = getDiv.find('.sumLike');

                var likeId = {getId: getId, currentUserId: currentUserId};

                if (likeButton.css('color') !== 'rgb(187, 154, 129)') {

                    $.ajax({
                        type: "POST",
                        url: "{{url('/postImage/like')}}",
                        data: likeId,
                        dataTy: 'json',
                        success: function (data) {

                            console.log(data)
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
                        url: "{{url('/postImage/reverseLike')}}",
                        data: likeId,
                        dataTy: 'json',
                        success: function (data) {

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
                    {{--url: "{{url('/postImage/getLike')}}",--}}
                    {{--data: likeId,--}}
                    {{--dataTy: 'json',--}}
                    {{--success: function (data) {--}}

                        {{--likeSection.text(data).append('<i>&nbsp;</i>').append($('<i class="fas fa-heart"></i>'))--}}

                    {{--},--}}
                {{--});--}}

            });
        // }
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

                                $('.def-content').append(data.imagePosts);
                                $('.endless-pagination').data('next-page',data.next_page);
                                isScroll=true;
                                checkCurrentLike();


                                $('.loader').css('display','none');
                            });
                        }
                    }
                },350))
            }
        }

    </script>

@endsection
