{!! Form::open(['action'=>'PostImageController@store', 'method'=>'POST', 'class'=>'ajax-form-sidebar']) !!}
<div class="modal fade" id="sidebar-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-group">
                    <div>Post with images</div>
                </div>
                {{Form::button('<span aria-hidden="true">&times;</span>',
                ['type'=>'button','class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'])}}
            </div>
            <div class="modal-body">

                <div class="def-desc">

                    <h6 class="inner-def-desc">Title:</h6>

                    <div class="sidebar-example">
                        <input id="definitionId" class="inner-sidebar-example"
                               placeholder="Title" name="title" autocomplete="off" type="text">
                    </div>

                    <h6 class="inner-def-desc">Content:</h6>

                    <div class="sidebar-example">
                        <textarea id="exampleId" class="inner-sidebar-example second-example"
                                  placeholder="Content" name="description" autocomplete="off"></textarea>
                    </div>
                </div>

                <div class="outer-upload">
                    {{Form::label('update_image_sidebar', 'Upload File', ['class'=>"upload-button"])}}
                    {{Form::file('update_image',['class'=>'update_image-sidebar d-none', 'onchange'=>'checkURL(this)','id'=>'update_image_sidebar'])}}
                    {{Form::button('Upload URL',['class'=>'createURLimage-sidebar'])}}
                    <div class="imageURLinput-sidebar"></div>
                </div>
                <div class="outer-image">
                    <img class="review-image-sidebar" id="imageId" src=""/>
                </div>
            </div>
            <div class="modal-footer">
                {{Form::button('Close',['class'=>"btn btn-secondary shutdown close-modal",'data-dismiss'=>'modal'])}}
                {{Form::submit('Save',['class'=>"btn btn-primary ajax-btn"])}}
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //    function to review uploading images

    function checkURL(input) {

        var imageReview = $(input).parent().parent().find('.review-image-sidebar');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            imageReview.attr('src', "");
            reader.onload = function (e) {
                imageReview.attr('src', e.target.result);

                $(".URLinputBox-sidebar").val("");

                $('.upload-button').css('color', '#BB9A81');
                $('.upload-button').css('background-color', '#49463D');

                $('.upload-button').hover(function () {
                    $('.upload-button').css('color', '#BB9A81');
                    $('.upload-button').css('background-color', '#49463D')
                }, function () {
                    $('.upload-button').css('color', '#BB9A81');
                    $('.upload-button').css('background-color', '#49463D')
                });

                resetUpLink()

                $('.imageURLinput-sidebar').empty()
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".createURLimage-sidebar").on('click', function () {

        $('.imageURLinput-sidebar').empty();
        $('.imageURLinput-sidebar').append($('<input class="URLinputBox-sidebar" type="text" placeholder="Paste image URL" name="URLinputBox" oninput="displayImage(this);">'));
        $('.update_image-sidebar').val(null);

        $(this).css('color', '#BB9A81');
        $(this).css('background-color', '#49463D');

        $(this).hover(function () {
            $(this).css('color', '#BB9A81');
            $(this).css('background-color', '#49463D')
        }, function () {
            $(this).css('color', '#BB9A81');
            $(this).css('background-color', '#49463D')
        });

        resetBtn()

    });

    function resetUpLink() {

        $(".createURLimage-sidebar").css('color', '#49463D');
        $(".createURLimage-sidebar").css('background-color', '#A39F8B');

        $(".createURLimage-sidebar").hover(function () {
            $(".createURLimage-sidebar").css('color', '#D1CBB3');
            $(".createURLimage-sidebar").css('background-color', '#49463D')
        }, function () {
            $(".createURLimage-sidebar").css('color', '#49463D');
            $(".createURLimage-sidebar").css('background-color', '#A39F8B')
        })
    }

    function resetBtn() {

        $(".upload-button").css('color', '#49463D');
        $(".upload-button").css('background-color', '#A39F8B');

        $(".upload-button").hover(function () {
            $(".upload-button").css('color', '#D1CBB3');
            $(".upload-button").css('background-color', '#49463D')
        }, function () {
            $(".upload-button").css('color', '#49463D');
            $(".upload-button").css('background-color', '#A39F8B')
        })
    }

    function displayImage(a) {

        $('.review-image-sidebar')
            .attr('src', $(a).val());
        console.log($(".URLinputBox-sidebar").val());
        $('.update_image-sidebar').val(null);
    }

    //    store newly created posts with image

    $(".ajax-form-sidebar").on("submit", function (e) {

        e.preventDefault();
        var data = new FormData($(this)[0]);
        console.log(data);
        var url = $(this).attr('action');
        var post = $(this).attr('method');

        $.ajax({
            type: post,
            url: url,
            data: data,
            dataTy: 'json',
            success: function (data) {

                if (window.location.href === "{{url('/postImage/show')}}") {

                    var count = $('.outer-word-display').length + 1;
                    console.log(count);

                    $('.outer-def-container').html(data);

                    displayCommentCountSidebar();

                    // deletePost();

                    likePost()

                    resetImage()

                    resetUpLink()

                    resetBtn()

                }else{
                    window.location.href = "{{url('/postImage/show')}}"
                }

                $('.fade').modal('hide')
            },
            contentType: false,
            cache: false,
            processData: false,
            async: false
        });

    });

    {{--function deletePost(){--}}

        {{--$('.fa-trash-alt').click(function () {--}}
            {{--var getId = $(this).parent().parent().find('.word-link').attr('href').substr(19);--}}

            {{--var outerDel = $(this).parent().parent();--}}

            {{--var delId = {getId: getId};--}}

            {{--$.ajax({--}}
                {{--type: "POST",--}}
                {{--url: "{{url('/postImage/delete')}}",--}}
                {{--data: delId,--}}
                {{--dataTy: 'json',--}}
                {{--success: function (data) {--}}
                    {{--outerDel.remove();--}}

                    {{--$('.prompt-msg').empty();--}}

                    {{--$('.prompt-msg').append($('<span>Removed</span>')).show().delay(3000).fadeOut();--}}

                {{--},--}}
            {{--});--}}

        {{--});--}}
    {{--}--}}


    //    close event to reset

    $(".ajax-form-sidebar").on("hidden.bs.modal", function () {

        resetImage()

        resetUpLink()

        resetBtn()
    });

    function resetImage(){
        $('.update_image-sidebar').val('');
        $('.review-image-sidebar').attr('src', null);
        $('.URLinputBox-sidebar').val(null);
        $('.imageURLinput-sidebar').empty();
        $('.inner-sidebar-example').empty()
    }

    $('.inner-sidebar-example').on("input", function () {
        $(this).val(capitalizeFirstLetter($(this).val()))
    })

    $('.second-example').on("input", function () {
        $(this).val(capitalizeFirstLetter($(this).val()))
    })

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function displayCommentCountSidebar() {

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

//    like function

    function likePost(){
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
                    url: "{{url('/postImage/like')}}",
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
                    url: "{{url('/postImage/reverseLike')}}",
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
                url: "{{url('/postImage/getLike')}}",
                data: likeId,
                dataTy: 'json',
                success: function (data) {

                    likeSection.text(data).append('<i>&nbsp;</i>').append($('<i class="fas fa-heart"></i>'))

                },
            });

        })
    }

</script>
