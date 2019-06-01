{!! Form::open(['action'=>'PostImageController@delete', 'method'=>'POST', 'class'=>'confirm-form']) !!}
<div class="modal fade" id="confirmModal{{$n}}" tabindex="-1" role="dialog"
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

    //    load ajax for deleting list requests

    $('.confirm-form').on('submit', function (e) {
        e.preventDefault();

        var getId = $(this).parent().find('.word-link').attr('href').substr(19);

        var outerDel = $(this).parent();

        var delId = {getId: getId};

        $.ajax({
            type: "POST",
            url: "{{url('/postImage/delete')}}",
            data: delId,
            dataTy: 'json',
            success: function (data) {

                $('.fade').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();

                outerDel.remove();

                $('.prompt-msg').empty();

                $('.prompt-msg').append($('<span>Removed Post</span>')).show().delay(3000).fadeOut();

            },
        });
    })
</script>
