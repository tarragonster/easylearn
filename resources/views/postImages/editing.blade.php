{!! Form::open(['action'=>'PostImageController@update', 'method'=>'POST', 'class'=>'ajax-form-postEdit']) !!}
<div class="modal fade" id="editing" tabindex="-1" role="dialog"
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

                <input class="post-id d-none" name="postId" type="text" value="">

                <div class="def-desc">

                    <h6 class="inner-def-desc">Title:</h6>

                    <div class="sidebar-example">
                        <input id="definitionId" class="inner-postEdit-example" value=""
                               placeholder="Title" name="title" autocomplete="off" type="text">
                    </div>

                    <h6 class="inner-def-desc">Content:</h6>

                    <div class="sidebar-example">
                        <textarea id="exampleId" class="inner-postEdit-example next-example"
                                  placeholder="Content" name="description" autocomplete="off"></textarea>
                    </div>
                </div>

                <div class="outer-upload">
                    {{Form::label('update_image_postEdit', 'Upload File', ['class'=>"upload-btn"])}}
                    {{Form::file('update_image',['class'=>'update_image-postEdit d-none', 'onchange'=>'injectURL(this)','id'=>'update_image_postEdit'])}}
                    {{Form::button('Upload URL',['class'=>'createURLimage-postEdit'])}}
                    <div class="imageURLinput-postEdit"></div>
                </div>
                <div class="outer-image">
                    <img class="review-image-postEdit" id="imageEdit" src=""/>
                </div>
            </div>
            <div class="modal-footer">
                {{Form::button('Close',['class'=>"btn btn-secondary shutdown close-modal",'data-dismiss'=>'modal'])}}
                {{Form::submit('Save',['class'=>"btn btn-primary the-ajax-btn"])}}
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

    function injectURL(input) {

        var imageReview = $(input).parent().parent().find('.review-image-postEdit');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            imageReview.attr('src', "");
            reader.onload = function (e) {
                imageReview.attr('src', e.target.result);

                $(".URLinputBox-postEdit").val("");
                console.log(input.files)
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".createURLimage-postEdit").on('click', function () {

        $('.imageURLinput-postEdit').empty();
        $('.imageURLinput-postEdit').append($('<input class="URLinputBox-postEdit" type="text" placeholder="Paste image URL" name="URLinputBox" oninput="display(this);">'));
        $('.update_image-sidebar').val(null);
    });

    function display(a) {

        $('.review-image-postEdit')
            .attr('src', $(a).val());

        $('.update_image-postEdit').val(null);
    }

    //    send request to edit the post

    $('.imageEdit').on('click', function () {

        var theId = $(this).attr('id');

        var anchor = $('.ajax-form-postEdit');

        console.log(this);

        $.ajax({
            type: "POST",
            url: "{{'/postImage/restartModal'}}",
            data: {id: theId},
            dataTy: 'json',
            async: false,
            success: function (data) {

                $.each(data, function (i, p) {

                    anchor.find('#definitionId').val(p.title);

                    anchor.find('#exampleId').val(p.description);

                    anchor.find('.review-image-postEdit').attr('src', p.update_image);

                    anchor.find('.imageURLinput-postEdit').empty();

                    anchor.find('.update_image-postEdit').val(null);

                    anchor.find('.post-id').val(theId);
                })
            },
        })

    });


    $(".ajax-form-postEdit").on("submit", function (e) {
        e.preventDefault();

        var btnPosition = $(this).find('.post-id').val();

        var anchor = $('#'+btnPosition).parent().parent();

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

                anchor.find('.word-link').text(data.title);
                anchor.find('.post-text').text(data.description);
                anchor.find('.postImg').attr('src', data.update_image);

                $('.fade').modal('hide')
            },

            contentType: false,
            cache: false,
            processData: false,
            async: false
        });

    });

</script>
