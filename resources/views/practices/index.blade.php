@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" href="{{asset('css/practice.css')}}" type="text/css">
@endsection

@section('content')
    <div class="left-container">
        <div class="search-container">
            <p class="search-title shadow">Word lists</p>
            <div class="search-cover small-search-cover shadow rounded">
                <div class="search-inner list-title">
                    @if(Auth::user() !== null)
                        <div class="userId d-none">{{Auth::user()->id}}</div>
                        <div class="creatorId d-none">{{$contentLists[0]->user_id}}</div>
                    @endif
                    <div>
                        <p class="nameList">{{$contentLists[0]->list}}</p>
                        @if(Auth::check() && Auth::user()->id == $contentLists[0]->user_id)
                            <span class="count"></span>
                        @endif
                    </div>

                    @if(Auth::check() && Auth::user()->id == $contentLists[0]->user_id)
                        <i class="fas fa-ellipsis-v delTitle" id="dropdownMenuButton" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false"></i>

                        <div class="dropdown-menu elipsisBtn" aria-labelledby="dropdownMenuButton">

                            <a class="dropdown-item shareBtn" href="{{ url('/public/show') }}">Share</a>
                            <span class="delDropdown dropdown-item" data-toggle="modal"
                                  data-target="#confirmModal">Delete</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="video-container smallScreen-content shadow rounded">
            <p class="search-title savedWord">Saved words</p>

            <div class="search-cover video-content inner-small-content">
                @if(count($contentLists)>0)
                    @foreach($contentLists as $contentList)
                        @if($contentList->word=='')
                            @continue
                        @else
                            <div class="d-none">{{$n++}}</div>
                            <div class="outer-word-display">
                                <a class="word-link"
                                   href="/lists/practice/{{$contentList->id}}">{{$contentList->word}}</a>
                                <div class="word-icon">
                                    @if(Auth::check() && Auth::user()->id == $contentList->user_id)
                                        <i class="fas fa-edit practiceEdit" data-toggle="modal"
                                           data-target="#editModalPractice" id="{{$contentList->id}}"></i>
                                        <i class="fas fa-trash-alt"></i>
                                    @endif
                                </div>
                                <div class="anchor-def"></div>
                            </div>
                        @endif
                    @endforeach
                    @include('practices.editModal')
                @endif
            </div>
        </div>
    </div>

    <button class="slide-saved-word"><i class="fas fa-angle-left"></i></button>

    <div class="article-container small-article">
        <p class="search-title alter-title" style="display: none">Word lists</p>

        <div class="search-cover left-cover shadow rounded">
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

        <div class="video-container shadow rounded">
            <p class="search-title savedWord">Images</p>

            <div class="search-cover video-content image-content">
                <div class="inner-image">
                    <span class="default_img">IMAGE</span>
                </div>
            </div>

        </div>
    </div>

    <div class="prompt-msg"></div>

    @include('practices.modal-delete-list')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var count = 0;
        var a = 0;
        var userId = $('.userId').text();
        var creatorId = $('.creatorId').text();

        $(document).ready(function () {
            displayCheck();

            if (userId !== '' && creatorId !== '' && userId === creatorId) {
                wordColor()
            }
        });


        function displayCheck() {
            var nameList = $('.nameList').text();

            $.ajax({
                type: "POST",
                url: "{{url('/lists/practice/sumCheck')}}",
                data: {nameList: nameList},
                dataTy: 'json',
                success: function (data) {

                    $('.count').text(data + '/' + $('.word-link').length);

                    reset(nameList, data, $('.word-link').length)
                },
            });
        }

        function wordColor() {
            $('.word-link').each(function () {
                var thisClick = $(this);
                var wordId = $(this).attr('href').substr(16);

                var ajaxData = {wordId: wordId};
                $.ajax({
                    type: "POST",
                    url: "{{url('/lists/practice/onload')}}",
                    data: ajaxData,
                    dataTy: 'json',
                    success: function (data) {

                        $.each(data, function (i, p) {
                            if (p.checked === 1) {
                                thisClick.css('color', 'rgb(87, 0, 5)')
                            } else {
                                thisClick.css('color', 'rgb(73, 70, 61)')
                            }
                        })
                    },
                });

            })
        }

        function reset(theList, theCount, theTotal) {
            if (theCount == theTotal) {

                $.ajax({
                    type: "POST",
                    url: "{{url('/lists/practice/reset')}}",
                    data: {theList: theList},
                    dataTy: 'json',
                    success: function (data) {
                        wordColor()
                    },
                });
            }
        }

        var numItems = $('.word-link').length;

        $('.word-link').click(function (event) {
            event.preventDefault();
            count++;


            var thisClick = $(this);
            var notThisClick = $('.anchor-def').not(thisClick.nextAll().eq(1));

            notThisClick.hide();
            $('.anchor-def').empty();

            $.get($(this).attr('href'), function (data) {

                console.log(data);

                $.each(data, function (i, p) {

                    //display content of the word

                    thisClick.nextAll().eq(1).append($('<span class="prony">' + p.pronunciation + '&nbsp;&nbsp;</span>')).append($('<span class="typie">' + p.type + '</span><br>'))
                        .append($('<p class="deffy">&#11035; ' + p.definition + '</p>')).append($('<p class="dis-example"><span>&#11035;</span> ' + p.example + '</p>')).toggle();

                    //change colour of the word


                    var ajaxList = {wordId: p.id, checked: 1};

                    if (thisClick.nextAll().eq(1).css('display') !== 'none') {

                        //display image of the word
                        $('.inner-image').empty();
                        $('.inner-image').append($('<img class="theImage" src="' + p.update_image + '" alt="">'));

                        if (userId !== '' && creatorId !== '' && userId === creatorId) {
                            $.ajax({
                                type: "POST",
                                url: "{{url('/lists/practice/checked')}}",
                                data: ajaxList,
                                dataTy: 'json',
                                success: function (data) {

                                    thisClick.css('color', 'rgb(87, 0, 5)');
                                    displayCheck()
                                },
                            });
                        }
                    }

                })
            });

            //   speak event after clicking on this link
            if (thisClick.nextAll().eq(1).css('display') === 'none') {
                responsiveVoice.speak($(this).text(), "UK English Male")
            }
        });


        $('.fa-trash-alt').click(function () {

            var getId = $(this).closest("div").prevAll(0).attr('href').substr(16);

            var delThis = $(this).closest("div").closest("div");

            var outerDel = delThis.parent().closest('div');

            outerDel.remove();

            var delId = {getId: getId};
            $.ajax({
                type: "POST",
                url: "{{url('/lists/practice/delete')}}",
                data: delId,
                dataTy: 'json',
                success: function (data) {
                    $('.prompt-msg').empty();

                    $('.prompt-msg').append($('<span>Removed ' + data + '</span>')).show().delay(3000).fadeOut();

                    $('.theImage').attr('src', '');
                },
            });

            $.get("{{'/lists/practice/delete'}}", function (data) {
                $.each(data, function (i, p) {
                    console.log(p.list)
                })
            });

            displayCheck()
        });

        $(document).mouseup(function (e) {

            if (!$('.slide-saved-word').is(e.target) && $('.slide-saved-word').has(e.target).length === 0
                && !$('.left-container').is(e.target) && $('.left-container').has(e.target).length === 0) {
                $('.left-container').attr('class', 'left-container');
                $('.slide-saved-word').attr('class', 'slide-saved-word');

                if ($('.left-container').width() !== 0) {
                    turnbtnAround()
                }

            }
        })

        $('.slide-saved-word').on('click', function () {
            $('.left-container').toggleClass('left-container-active');
            $(this).toggleClass('btn-position');
            turnbtnAround()
        })

        function turnbtnAround() {

            if ($('.left-container').width() !== 0) {
                $('.slide-saved-word').empty();
                $('.slide-saved-word').html('<i class="fas fa-angle-left"></i>')
            } else {
                $('.slide-saved-word').empty();
                $('.slide-saved-word').html('<i class="fas fa-angle-right"></i>')
            }

        }

        $('.shareBtn').on('click', function (e) {
            e.preventDefault();

            var id = $(this).parent().parent().find('.userId').text();

            var list = $(this).parent().parent().find('.nameList').text();

            var data = {id: id, list: list};

            var shareBtn = $(this);


            $.ajax({
                type: "POST",
                url: "{{url('/lists/practice/share')}}",
                data: data,
                dataTy: 'json',
                success: function (data) {

                    shareBtn.text('Share');
                    shareBtn.css('color', '#49463D');

                    if(data == 0){
                        window.location.href = shareBtn.attr('href')
                    }

                },
            });

        })

        $('.delTitle').on('click', function () {

            var id = $(this).parent().find('.userId').text();

            var list = $(this).parent().find('.nameList').text();

            var data = {id: id, list: list};

            var shareBtn = $(this).parent().find('.shareBtn')

            $.ajax({
                type: "POST",
                url: "{{url('/lists/practice/checkShare')}}",
                data: data,
                dataTy: 'json',
                success: function (data) {

                    if (data > 0) {

                        shareBtn.text('Shared');
                        shareBtn.css('color', '#9E1617')

                    }

                },
            });
        })

    </script>

@endsection
