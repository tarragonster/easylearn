{!! Form::open(['action'=>'PostVideoController@store', 'method'=>'POST', 'class'=>'ajax-form-video']) !!}
<div class="modal fade" id="video-modal" tabindex="-1" role="dialog"
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
                        <input id="definitionId" class="inner-video-example"
                               placeholder="Title" name="title" autocomplete="off" type="text">
                    </div>

                    <h6 class="inner-def-desc">Content:</h6>

                    <div class="sidebar-example">
                        <textarea id="exampleId" class="inner-video-example third-example"
                                  placeholder="Content" name="description" autocomplete="off"></textarea>
                    </div>
                </div>

                <div class="outer-upload">

                    {{Form::button('Youtube',['class'=>"upload-button-video"])}}
                    {{Form::button('Iframe',['class'=>'createURLimage-video'])}}
                    <div class="imageURLinput-video"></div>
                </div>
                <div class="outer-image">
                    <div class="review-image-video"></div>
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

    $(".ajax-form-video").on("submit", function (e) {
        e.preventDefault();

        var modal = $(this);

        var youtubeTag = $(this).find('.youtube-video');
        var youtubeLink = displayVideo(youtubeTag);


        var iframeLink = $(this).find('.iframe-video').val();
        var title = $(this).find('#definitionId').val();
        var desc = $(this).find('#exampleId').val();


        var data = {youtube: youtubeLink, iframe: iframeLink, title: title, desc: desc};
        var url = $(this).attr('action');
        var post = $(this).attr('method');

        $.ajax({
            type: post,
            url: url,
            data: data,
            dataTy: 'json',
            success: function (data) {

                if (window.location.href === "{{url('/postVideo/show')}}") {

                    var count = $('.outer-word-display').length + 1;
                    console.log(count);

                    $('.outer-def-container').html(data);

                    convertHTML()

                    displayCommentNum();

                    // deletePost();

                    likePost();

                    resetVid(modal)


                }else{
                    window.location.href = "{{url('/postVideo/show')}}"
                    }

                    $('.fade').modal('hide')
                },
                async: false,
            });

    });

    function convertHTML(){
        $('.disVid').each(function () {
            var anchor = $(this).parent();
            anchor.html($(this).text())
        })
    }

    $('.ajax-form-video').on('hidden.bs.modal', function (e) {
        var modal = $(this);

        resetVid(modal)

    });

    function resetVid(modal) {

        modal.find('.inner-video-example').val('');
        modal.find('.imageURLinput-video').empty();
        modal.find('.review-image-video').empty();

        resetYoutube();
        resetIframe()

    }


    $(".upload-button-video").on('click', function () {

        $('.imageURLinput-video').empty();
        $('.imageURLinput-video').append($('<input class="youtube-video" type="text" placeholder="Paste Youtube URL" name="theVideo" oninput="displayVideo(this);">'));

        $(this).css('color', '#BB9A81');
        $(this).css('background-color', '#49463D');

        $(this).hover(function () {
            $(this).css('color', '#BB9A81');
            $(this).css('background-color', '#49463D')
        }, function () {
            $(this).css('color', '#BB9A81');
            $(this).css('background-color', '#49463D')
        });

        resetIframe()

    });

    function resetYoutube() {

        $(".upload-button-video").css('color', '#49463D');
        $(".upload-button-video").css('background-color', '#A39F8B');

        $(".upload-button-video").hover(function () {
            $(".upload-button-video").css('color', '#D1CBB3');
            $(".upload-button-video").css('background-color', '#49463D')
        }, function () {
            $(".upload-button-video").css('color', '#49463D');
            $(".upload-button-video").css('background-color', '#A39F8B')
        })
    }

    function resetIframe() {

        $(".createURLimage-video").css('color', '#49463D');
        $(".createURLimage-video").css('background-color', '#A39F8B');

        $(".createURLimage-video").hover(function () {
            $(".createURLimage-video").css('color', '#D1CBB3');
            $(".createURLimage-video").css('background-color', '#49463D')
        }, function () {
            $(".createURLimage-video").css('color', '#49463D');
            $(".createURLimage-video").css('background-color', '#A39F8B')
        })
    }


    $(".createURLimage-video").on('click', function () {

        $('.imageURLinput-video').empty();
        $('.imageURLinput-video').append($('<input class="iframe-video" type="text" placeholder="Paste embed iframe" name="theVideo" oninput="displayIframe(this);">'));

        $(this).css('color', '#BB9A81');
        $(this).css('background-color', '#49463D');

        $(this).hover(function () {
            $(this).css('color', '#BB9A81');
            $(this).css('background-color', '#49463D')
        }, function () {
            $(this).css('color', '#BB9A81');
            $(this).css('background-color', '#49463D')
        })

        resetYoutube()
    });

    function displayIframe(input) {

        var iframeAttach = $(input).val();

        if(typeof iframeAttach ==='string'){
            var n = iframeAttach.lastIndexOf("<iframe ");

            if(n !== 0){
                iframeAttach = iframeAttach.substr(n,iframeAttach.length);
                $(input).val(iframeAttach)
            }

            $('.review-image-video').html($(input).val())
        }else{
            $('.review-image-video').html('')
        }
    }

    function displayVideo(input) {

        var url = $(input).val();

        if(typeof url === 'string'){
            var n = url.lastIndexOf("https://www.youtube.com");

            if(n !== 0){
                url = url.substr(n,url.length);
                $(input).val(url)
            }

            var youtubeId = getId($(input).val());
            var iframeLink = '<iframe src="//www.youtube.com/embed/' + youtubeId + '" frameborder="0" allowfullscreen></iframe>';

            $('.review-image-video')
                .html(iframeLink);

            if (youtubeId === 'error')

                return '';
            else {
                return iframeLink
            }
        }else{
            return '';
        }
    }


    function getId(url) {
        if (url == null) {
            return 'error'
        } else {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
            var match = url.match(regExp);

            if (match && match[2].length == 11) {
                return match[2];
            } else {
                return 'error';
            }
        }
    }

    {{--function deletePost() {--}}

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
    {{--}--}}

    function likePost() {

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

</script>
