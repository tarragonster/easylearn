{!! Form::open(['action'=>'PracticeController@editModal', 'method'=>'POST', 'class'=>'ajax-form']) !!}
<div class="modal fade theSmall-opt" id="editModalPractice" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-group">
                    <div id="list-title"></div>
                </div>
                {{Form::button('<span aria-hidden="true">&times;</span>',
                ['type'=>'button','class'=>'close','data-dismiss'=>'modal','aria-label'=>'Close'])}}
            </div>
            <div class="modal-body">

                <div class="body-top">
                    {{ Form::label('word', 'Word',['class'=>"col-sm-2 col-form-label d-none"])}}
                    <div class="outer-word">
                        {{Form::text('word','',['class'=>'inner-word','id'=>'wordId'])}}
                    </div>

                    {{ Form::label('pronunciation', 'Pronunciation',['class'=>"col-sm-2 col-form-label d-none"])}}
                    <div class="outer-word">
                        {{Form::text('pronunciation','',['class'=>'inner-word','id'=>'pronunciationId'])}}
                    </div>

                    {{ Form::label('type', 'Type',['class'=>"col-sm-2 col-form-label d-none"])}}
                    <div class="outer-word">
                        {{Form::text('type','',['class'=>'inner-word', 'id'=>'typeId'])}}
                    </div>

                    {{ Form::label('id', 'Type',['class'=>"col-sm-2 col-form-label d-none"])}}
                    <div class="outer-word d-none">
                        {{Form::text('id','',['class'=>'inner-word', 'id'=>'theIdId'])}}
                    </div>

                </div>

                <div class="def-desc">

                    <h6 class="inner-def-desc">Definition:</h6>

                    <div class="outer-example">
                        <textarea id="definitionId" class="inner-example"
                                  placeholder="Definition" name="definition"
                                  autocomplete="off"></textarea>
                    </div>

                    <h6 class="inner-def-desc">Example:</h6>

                    <div class="outer-example">
                        <textarea id="exampleId" class="inner-example"
                                  placeholder="Example" name="example"
                                  autocomplete="off"></textarea>
                    </div>
                </div>

                <div class="outer-upload">
                    {{Form::label('update_image'.$n, 'Upload File', ['class'=>"upload-button"])}}
                    {{Form::file('update_image',['class'=>'update_image d-none', 'onchange'=>'readURL(this)','id'=>'update_image'.$n])}}
                    {{Form::button('Upload URL',['class'=>'createURLimage'])}}
                    <div class="imageURLinput"></div>
                </div>
                <div class="outer-image">
                    <img class="review-image" id="imageId{{$n}}" src=""/>
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

    // $(document).ready(function () {
    //
    //     closeForm()
    // });

    function readURL(input) {

        var imageReview = $(input).parent().parent().find('.review-image');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            imageReview.attr('src', "");
            reader.onload = function (e) {
                imageReview.attr('src', e.target.result);

                $(".URLinputBox").val("");

                $('.upload-button').css('color', '#BB9A81');
                $('.upload-button').css('background-color', '#49463D');

                $('.upload-button').hover(function () {
                    $('.upload-button').css('color', '#BB9A81');
                    $('.upload-button').css('background-color', '#49463D')
                }, function () {
                    $('.upload-button').css('color', '#BB9A81');
                    $('.upload-button').css('background-color', '#49463D')
                });

                resetBtn()
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    //open modal editing

    $('.practiceEdit').click(function () {

        var theId = $(this).attr('id');

        var ajaxList = {nameList: theId};

        var thisEditForm = $('.ajax-form');

        console.log(this);

        $.ajax({
            type: "POST",
            url: "{{'/lists/practice/restart'}}",
            data: ajaxList,
            dataTy: 'json',

            success: function (data) {
                $.each(data, function (i, p) {

                    thisEditForm.find('#list-title').text(p.list);

                    thisEditForm.find('#wordId').val(p.word);

                    thisEditForm.find('#pronunciationId').val(p.pronunciation);

                    thisEditForm.find('#typeId').val(p.type);

                    thisEditForm.find('#definitionId').val(p.definition);

                    thisEditForm.find('#exampleId').val(p.example);

                    thisEditForm.find('.update_image').val(null);

                    thisEditForm.find('.review-image').attr('src', p.update_image);

                    thisEditForm.find('#theIdId').val(theId);

                    $('.imageURLinput').empty();

                    resetUpLink();

                    resetBtn()

                })
            },
        });

    });

    //event submitting modal

    $('.ajax-form').on('submit', function (e) {
        e.preventDefault();

        var btnPosition = $(this).find('#theIdId').val();

        var anchor = $('#'+ btnPosition).parent().parent();

        console.log(anchor)

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

                anchor.find('.word-link').text(data.word);
                anchor.find('.prony').text(data.pronunciation);
                anchor.find('.typie').text(data.type);
                anchor.find('.deffy').text(data.definition);
                anchor.find('.dis-example').text(data.example);
                $('.theImage').attr('src', data.update_image);

                $('.fade').modal('hide');

                resetUpLink();

                resetBtn()
            },
            contentType: false,
            cache: false,
            processData: false,
            async: false
        })
    });



    //    event after closing modal (unload images from the modal)


    $(".createURLimage").on('click', function () {

        $('.imageURLinput').empty();
        $('.imageURLinput').append($('<input class="URLinputBox" type="text" name="URLinputBox" oninput="displayOnImage(this);">'));
        $('.update_image').val(null);

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

        $(".createURLimage").css('color', '#49463D');
        $(".createURLimage").css('background-color', '#A39F8B');

        $(".createURLimage").hover(function () {
            $(".createURLimage").css('color', '#D1CBB3');
            $(".createURLimage").css('background-color', '#49463D')
        }, function () {
            $(".createURLimage").css('color', '#49463D');
            $(".createURLimage").css('background-color', '#A39F8B')
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

    function displayOnImage(a) {

        $('.review-image')
            .attr('src', $(a).val());
        console.log($(".URLinputBox").val());
        $('.update_image').val(null);
    }

</script>
