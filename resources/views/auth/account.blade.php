@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" href="{{asset('css/search.css')}}" type="text/css">
@endsection

@section('content')
    <div class="top-container">
        <div class="search-container">
            <p class="heading-title">Articles</p>
            <div class="heading">
                <div class="inner-heading">
                    <h4 id="display">{{Auth::user()->name}}'s Account</h4>

                </div>
                {{--<hr>--}}
            </div>
        </div>
        <div class="heading searching">
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

    <div class="outer-def-container">
        <div class="def-container">
            <div class="inner-def">
                <div class="def-content">
                    <div class="outer-word-display">
                        <div class="anchor-def">
                            <div class="search-cover">
                                <img class="review-image-account" id="imageId" src="{{Auth::user()->user_image}}">
                            </div>
                            <div class="post-content">
                                <form action="{{ action('Auth\LoginController@updateAccount')}}" method="POST" class="form-account" enctype="multipart/form-data">

                                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                                    <div class="account-upload upper-upload">

                                        <input type="text" class="d-none" name="id" value="{{Auth::user()->id}}">

                                        <div class="outer-userName">
                                            <span>Your Name</span>
                                            <div class="outer-inputName">
                                                <input type="text" id="userName" name="name" value="{{Auth::user()->name}}">
                                            </div>
                                        </div>
                                        <div class="outer-email">
                                            <span>Your Email</span>
                                            <div class="outer-inputEmail{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <input type="text" id="userEmail" name="email" value="{{Auth::user()->email}}">

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        {{ $errors->first('email') }}
                                                    </span>
                                                @endif

                                            </div>
                                        </div>
                                    </div>

                                    <div class="outer-upload account-upload">
                                        <label for="update_image_acc" class="upload-button">Upload Image</label>
                                        <input type="file" class="update_image_acc d-none" onchange="accURL(this)" id="update_image_acc" name="update_image">
                                        <input type="button" class="createURLimage-account" value="Upload URL">
                                        <div class="imageURLinput-account"></div>
                                    </div>

                                    <div class="submit-section">
                                        <input type="submit" value="Save changes" class="submit-btn">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //    function to review uploading images

        function accURL(input) {

            var imageReview = $(input).parent().parent().parent().parent().find('.review-image-account');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                imageReview.attr('src', "");
                reader.onload = function (e) {
                    imageReview.attr('src', e.target.result);

                    $(".URLinputBox").val("");
                    console.log(input.files)
                };

                reader.readAsDataURL(input.files[0  ]);
            }
        }

        $(".createURLimage-account").on('click', function () {

            $('.imageURLinput-account').empty();
            $('.imageURLinput-account').append($('<input class="URLinputBox" type="text" name="URLinputBox" oninput="displayImageAccount(this);">'));
            $('.update_image_acc').val(null);
        });

        function displayImageAccount(a) {

            $('.review-image-account')
                .attr('src', $(a).val());
            console.log($(".URLinputBox").val());
            $('.update_image_acc').val(null);
        }
    </script>
@endsection
