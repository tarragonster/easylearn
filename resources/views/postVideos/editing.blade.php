{!! Form::open(['action'=>'PostVideoController@update', 'method'=>'POST', 'class'=>'ajax-form-videoEdit']) !!}
<div class="modal fade" id="editVid" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-group">
                    <div>Post with videos</div>
                </div>
                {{Form::button('<span aria-hidden="true">&times;</span>',
                ['type'=>'button','class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'])}}
            </div>
            <div class="modal-body">

                <input class="edit-id d-none" name="postId" type="text" value="">

                <div class="def-desc">

                    <h6 class="inner-def-desc">Title:</h6>

                    <div class="sidebar-example">
                        <input id="definitionId" class="inner-editVid-example" value=""
                               placeholder="Title" name="title" autocomplete="off" type="text">
                    </div>

                    <h6 class="inner-def-desc">Content:</h6>

                    <div class="sidebar-example">
                        <textarea id="exampleId" class="inner-editVid-example third-example"
                                  placeholder="Content" name="description"
                                  autocomplete="off"></textarea>
                    </div>
                </div>

                <div class="outer-upload">

                    {{Form::button('Youtube',['class'=>"upload-button-edit"])}}
                    {{Form::button('Iframe',['class'=>'createURLimage-edit'])}}
                    <div class="imageURLinput-edit"></div>
                </div>
                <div class="outer-image">
                    <div class="review-image-edit">
                        <div class="disVid"></div>
                    </div>
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

    function convertHTML() {
        $('.disVid').each(function () {
            var anchor = $(this).parent();
            anchor.html($(this).text())
        })
    }

    //    function to review uploading images


    function display(a) {

        $('.review-image-postEdit')
            .attr('src', $(a).val());

        $('.update_image-postEdit').val(null);
    }

    // open modal

    $('.videoEdit').on('click', function () {

        var theId = $(this).attr('id');

        var anchor = $('.ajax-form-videoEdit');

        $.ajax({
            type: "POST",
            url: "{{'/postVideo/restartModal'}}",
            data: {id: theId},
            dataTy: 'json',
            async: false,
            success: function (data) {

                $.each(data, function (i, p) {

                    anchor.find('#definitionId').val(p.title);

                    anchor.find('#exampleId').val(p.description);

                    anchor.find('.review-image-edit').empty();

                    anchor.find('.review-image-edit').append(p.video);

                    anchor.find('.imageURLinput-edit').empty();

                    anchor.find('.edit-id').val(theId);
                })
            },
        })

    })

    //    send request to edit the post

    $(".ajax-form-videoEdit").on("submit", function (e) {
        e.preventDefault();

        var btnPosition = $(this).find('.edit-id').val();

        var anchor = $('#'+btnPosition).parent().parent();

        var youtubeTag = $(this).find('.youtube-edit');
        var youtubeLink = displayThisVideo(youtubeTag);


        var iframeLink = $(this).find('.iframe-edit').val();
        var title = $(this).find('#definitionId').val();
        var desc = $(this).find('#exampleId').val();
        var postId = $(this).find('.edit-id').val();


        var data = {youtube: youtubeLink, iframe: iframeLink, title: title, desc: desc, postId: postId};

        var url = $(this).attr('action');
        var post = $(this).attr('method');

        console.log(data);

        $.ajax({
            type: post,
            url: url,
            data: data,
            dataTy: 'json',

            success: function (data) {

                anchor.find('.word-link').text(data.title);
                anchor.find('.post-text').text(data.description);
                anchor.find('.search-cover').empty()
                anchor.find('.search-cover').html(data.video);

                convertHTML();

                $('.fade').modal('hide')
            },
            async: false,
        });

    });


    $(".upload-button-edit").on('click', function () {

        $('.imageURLinput-edit').empty();
        $('.imageURLinput-edit').append($('<input class="youtube-edit" type="text" placeholder="Paste Youtube URL" name="theVideo" oninput="displayThisVideo(this);">'));

        $(this).css('color', '#BB9A81');
        $(this).css('background-color', '#49463D');

        $(this).hover(function () {
            $(this).css('color', '#BB9A81');
            $(this).css('background-color', '#49463D')
        }, function () {
            $(this).css('color', '#BB9A81');
            $(this).css('background-color', '#49463D')
        });

        resetIframeEdit()

    });

    function resetYoutubeEdit() {

        $(".upload-button-edit").css('color', '#49463D');
        $(".upload-button-edit").css('background-color', '#A39F8B');

        $(".upload-button-edit").hover(function () {
            $(".upload-button-edit").css('color', '#D1CBB3');
            $(".upload-button-edit").css('background-color', '#49463D')
        }, function () {
            $(".upload-button-edit").css('color', '#49463D');
            $(".upload-button-edit").css('background-color', '#A39F8B')
        })
    }

    function resetIframeEdit() {

        $(".createURLimage-edit").css('color', '#49463D');
        $(".createURLimage-edit").css('background-color', '#A39F8B');

        $(".createURLimage-edit").hover(function () {
            $(".createURLimage-edit").css('color', '#D1CBB3');
            $(".createURLimage-edit").css('background-color', '#49463D')
        }, function () {
            $(".createURLimage-edit").css('color', '#49463D');
            $(".createURLimage-edit").css('background-color', '#A39F8B')
        })
    }


    $(".createURLimage-edit").on('click', function () {

        $('.imageURLinput-edit').empty();
        $('.imageURLinput-edit').append($('<input class="iframe-edit" type="text" placeholder="Paste embed iframe" name="theVideo" oninput="displayThisIframe(this);">'));

        $(this).css('color', '#BB9A81');
        $(this).css('background-color', '#49463D');

        $(this).hover(function () {
            $(this).css('color', '#BB9A81');
            $(this).css('background-color', '#49463D')
        }, function () {
            $(this).css('color', '#BB9A81');
            $(this).css('background-color', '#49463D')
        })

        resetYoutubeEdit()
    });

    function displayThisVideo(input) {

        var url = $(input).val();

        if (typeof url === 'string') {
            var n = url.lastIndexOf("https://www.youtube.com");

            if (n !== 0) {
                url = url.substr(n, url.length);
                $(input).val(url)
            }

            var youtubeId = getId(url);
            var iframeLink = '<iframe src="//www.youtube.com/embed/' + youtubeId + '" frameborder="0" allowfullscreen></iframe>';

            $('.review-image-edit')
                .html(iframeLink);

            if (youtubeId === 'error')

                return '';
            else {
                return iframeLink
            }

        } else {
            return '';
        }
    }

    function displayThisIframe(input) {

        var iframeAttach = $(input).val();

        if (typeof iframeAttach === 'string') {
            var n = iframeAttach.lastIndexOf("<iframe ");

            if (n !== 0) {
                iframeAttach = iframeAttach.substr(n, iframeAttach.length);
                $(input).val(iframeAttach)
            }

            $('.review-image-edit').html($(input).val())
        } else {
            $('.review-image-video').html('')
        }
    }

</script>
