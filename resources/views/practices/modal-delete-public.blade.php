{!! Form::open(['action'=>'ShareToPublicController@delete', 'method'=>'POST', 'class'=>'public-form']) !!}
<div class="modal fade" id="publicDelModal" tabindex="-1" role="dialog"
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
                <div class="public-id d-none"></div>
                <div class="def-desc">
                    <h6 class="inner-def-desc">Are you sure you want to delete this list?<br><br>
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
    
    $('.delTitle').on('click', function () {

        var id = $(this).attr('id').substr(18);

        var anchor = $('.public-form');

        anchor.find('.public-id').text(id)

    })

    $('.public-form').on('submit',function (e) {
        e.preventDefault();

        var url = $(this).attr('action');
        var post = $(this).attr('method');
        var id = $(this).find('.public-id').text();

        $.ajax({
            type: post,
            url: url,
            data: {id:id},
            dataTy: 'json',
            success: function (data) {
                $('.fade').modal('hide');

                $('#dropdownMenuButton'+id).parent().parent().parent().parent().remove();

            },
        });

    })
    
</script>
