
<!--Modal: Name-->
<div class="modal fade vidModal" id="modalYT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <!--Content-->
        <div class="modal-content">

            <!--Body-->
            <div class="modal-body mb-0 p-0">

                <div class="embed-responsive embed-responsive-16by9 z-depth-1-half">
                    <div class="anchor-iframe">
                        <div class="inner-anchor-iframe">
                            <div class="disVid d-none">{{$videoPost->video}}</div>
                        </div>
                    </div>
                </div>

            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <span class="mr-4">Spread the word!</span>
                <a type="button" class="btn-floating btn-sm btn-fb"><i class="fab fa-facebook-f"></i></a>
                <!--Twitter-->
                <a type="button" class="btn-floating btn-sm btn-tw"><i class="fab fa-twitter"></i></a>
                <!--Google +-->
                <a type="button" class="btn-floating btn-sm btn-gplus"><i class="fab fa-google-plus-g"></i></a>
                <!--Linkedin-->
                <a type="button" class="btn-floating btn-sm btn-ins"><i class="fab fa-linkedin-in"></i></a>

                <button type="button" class="btn btn-outline-primary btn-rounded btn-md ml-4 close-vidModal" data-dismiss="modal">Close</button>

            </div>

        </div>
        <!--/.Content-->

    </div>
</div>
