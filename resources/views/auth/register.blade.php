@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" href="{{asset('css/search.css')}}" type="text/css">
@endsection

@section('content')
    <div class="outer-def-container">
        <div class="def-container">
            <div class="inner-def">
                <div class="def-content">
                    <div class="outer-word-display">
                        <div class="anchor-def">
                            {{--<div class="card-header">{{ __('Register') }}</div>--}}

                            <div class="search-cover">
                                <img class="review-image-account" id="imageId"
                                     src="/storage/update_images/default_user.jpg">
                            </div>

                            <div class="post-content">

                                <form method="POST" action="{{url('register')}}" class="form-account"
                                      enctype="multipart/form-data">
                                    @csrf

                                    <div class="account-upload upper-upload">

                                        <div class="outer-userName">

                                            <span class="name-field">{{ __('Name') }}</span>

                                            <div class="outer-inputName{{ $errors->has('name') ? ' has-error' : '' }}">
                                                <input id="userName" type="text" name="name" value="{{old('name')}}">

                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        {{ $errors->first('name') }}
                                                    </span>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="outer-email">

                                            <span class="name-field">{{ __('E-Mail Address') }}</span>

                                            <div class="outer-inputEmail{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <input id="userEmail" type="email" name="email" value="{{old('email')}}">

                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        {{ $errors->first('email') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="outer-email">
                                            <span class="name-field">{{ __('Password') }}</span>

                                            <div class="outer-inputEmail{{ $errors->has('password') ? ' has-error' : '' }} ">
                                                <input id="password" type="password" name="password">

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        {{ $errors->first('password') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="outer-email">
                                            <span class="name-field">{{ __('Confirm Password') }}</span>

                                            <div class="outer-inputEmail">
                                                <input id="password-confirm" type="password"
                                                       name="password_confirmation">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="outer-upload account-upload">
                                        <label for="update_image_acc" class="upload-button">Upload Image</label>
                                        <input type="file" class="update_image_acc d-none" onchange="accURL(this)"
                                               id="update_image_acc" name="update_image">
                                        <input type="button" class="createURLimage-account" value="Upload URL">
                                        <div class="imageURLinput-account"></div>
                                    </div>


                                    <div class="submit-section">
                                        <button type="submit" class="submit-btn">
                                            {{ __('Register') }}
                                        </button>
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

                reader.readAsDataURL(input.files[0]);
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
