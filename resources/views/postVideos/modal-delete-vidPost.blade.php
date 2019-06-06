{!! Form::open(['action'=>'PostVideoController@delete', 'method'=>'POST', 'class'=>'confirm-form']) !!}
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-group">
                    <div>Confirmation</div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="def-desc">
                    <h6 class="inner-def-desc">Are you sure you want to delete this post?<br><br>
                        Note: Deleting list is permanent action and cannot be undone</h6>

                    <input class="postDel-id d-none" name="postId" type="text" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary shutdown close-modal" data-dismiss="modal" type="button">Close</button>
                <input class="btn btn-primary ajax-btn" type="submit" value="Delete">
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

    $(document).on('click','.videoDel', function () {

        var theId = $(this).attr('id').substr(7);

        var anchor = $('.confirm-form').find('.postDel-id');

        anchor.val(theId);

    });

    //    load ajax for deleting list requests

    $('.confirm-form').on('submit', function (e) {
        e.preventDefault();

        var getId = $(this).find('.postDel-id').val();

        var outerDel = $('#delThis'+getId).parent().parent();

        var delId = {getId: getId};

        $.ajax({
            type: "POST",
            url: "{{url('/postVideo/delete')}}",
            data: delId,
            dataTy: 'json',
            success: function (data) {

                $('.fade').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                outerDel.remove();

                $('.prompt-msg').empty();

                $('.prompt-msg').append($('<span>Removed Post</span>')).show().delay(3000).fadeOut();

                fetchPosts()
            },
        });
    })
</script>
