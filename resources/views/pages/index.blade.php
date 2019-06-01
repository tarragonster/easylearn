@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" href="{{asset('css/home.css')}}" type="text/css">
@endsection

@section('content')

    <div class="left-container">
        <div class="search-container">
            <p class="search-title shadow">Dictionary</p>
            <div class="search-cover shadow rounded">
                <div class="search-inner">
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

        <div class="video-container">
            <p class="search-title video shadow">New Videos</p>

            <div class="search-cover video-content shadow rounded">
                @include('pages.slide-video')
            </div>
        </div>

    </div>

    <div class="article-container">
        <p class="search-title shadow">New Articles</p>

        <div class="search-cover article-content shadow rounded">
            @include('pages.article-data')
        </div>
    </div>

    <div class="prompt-msg"></div>
@endsection

<script>

    window.onload = function(){

        clickLink();

        checkCurrentLike();

        addLike();

        // displayCommentCount();

        var oldURL = document.referrer;

        var extractURL = oldURL.substr(0,27);

        if(extractURL ==="http://127.0.0.1:8000/lists"){
            var counter = 0;

            var paramList = oldURL.substr(28,oldURL.length-37);

            $.get("{{'/search/dropdown'}}",function(data){

                $.each(data[0],function(i,p){

                    if(p.list === paramList){
                        counter++;
                    }
                });

                if(counter===0){
                    $('.prompt-msg').empty();

                    $('.prompt-msg').append($('<span>Removed '+paramList+'</span>')).show().delay(3000).fadeOut()
                }else{
                    $('.prompt-msg').empty();
                }
            });
        }

    };

    function clickLink(){
        $(document).on('click','.page-link',function (e) {
            e.preventDefault();

            var page = $(this).attr('href').split('page=')[1];

            fetch_data(page)

        })
    }

    function fetch_data(page){

        $.ajax({
            url:"/pagination?page="+page,
            success:function(data){

                $('.article-content').html(data)

                checkCurrentLike()

                addLike()

                displayCommentCount();
            }
        })
    }

    function checkCurrentLike(){

        $('.currentLike').each(function () {

            console.log($(this).text());

            if ($(this).text() === '1') {

                var outerDiv = $(this).parent();

                var likeButton = outerDiv.find('.like-btn');

                likeButton.css('color', '#BB9A81');

            }
        })
    }

    function addLike(){

        $('.like-btn').on('click', function () {

            var likeButton = $(this);

            var getDiv = likeButton.parent().parent().parent().parent().parent().parent().parent().parent();

            var getId = getDiv.find('.word-link').text();

            var currentUserId = getDiv.find('.currentId').text();

            var likeId = {getId: getId, currentUserId: currentUserId};

            console.log(likeButton.css('color'));

            if (likeButton.css('color') !== 'rgb(187, 154, 129)') {

                $.ajax({
                    type: "POST",
                    url: "{{url('/postImage/like')}}",
                    data: likeId,
                    dataTy: 'json',
                    success: function (data) {

                        console.log(data);

                        likeButton.css('color', '#BB9A81');

                    },
                });
            } else {

                $.ajax({
                    type: "POST",
                    url: "{{url('/postImage/reverseLike')}}",
                    data: likeId,
                    dataTy: 'json',
                    success: function (data) {

                        console.log(data);

                        likeButton.css('color', '#49463D');

                    },
                });
            }

            var likeSection = getDiv.find('.like-section');

            $.ajax({
                type: "POST",
                url: "{{url('/postImage/getLike')}}",
                data: likeId,
                dataTy: 'json',
                success: function (data) {

                    likeSection.text(data)

                },
            });

        })
    }

    function displayCommentCount() {

        $('.word-link').each(function () {

            var post ={
                id: $(this).text(),

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

</script>
