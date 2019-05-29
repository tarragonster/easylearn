<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="slideVid active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1" class="slideVid"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2" class="slideVid"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3" class="slideVid"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="4" class="slideVid"></li>
    </ol>
    <div class="carousel-inner">
        @if(count($videos)>0)
            @foreach($videos as $video)
                <div class="carousel-item">

                    <div class="forIframe">
                        <div class="vid-container" style="width: 100%; height: 100%">{{$video->video}}</div>
                    </div>

                    <div class="outer-vidInfo">
                        <div class="vidTitle"><a href="/postVideo/comment/{{$video->id}}">{{$video->title}}</a></div>
                        <div class="name-date">
                            <div class="vidUser-portion">
                                <div class="vidUserImage">
                                    <img src="{{$video->user[0]->user_image}}" alt="">
                                </div>
                                <div class="vidUserCreate">{{$video->user[0]->name}}</div>
                            </div>
                            <div class="timeVid">{{Carbon\Carbon::parse($video->created_at)->diffForHumans()}}</div>
                        </div>
                    </div>
                </div>
            @endforeach

        @else
            <span>No Video found</span>
        @endif

    </div>
</div>

<script>
    $(document).ready(function () {
        changeClass();
        conHTML()

    });

    function conHTML(){

        $('.vid-container').each(function () {
            var anchor = $(this).parent();
            anchor.html($(this).text())

        })
    }

    function changeClass(){

        $('.carousel-item').first().attr('class','carousel-item active')
    }

    $('.carousel').carousel({
        interval: false
    });

//    stop playing videos after sliding into the next page

        $('.slideVid').on('click',function () {

        // get class index of not this clicked event

            $(".slideVid").not(this).each(function () {

                var id = $(this).index();

                // get other videos with the same class but not on this click

                var assoVid = $('.forIframe:eq('+id+')');

                //    get html iframe of this div

                var thisIframe = assoVid.html();

                assoVid.empty();

                //    append this iframe into empty slider

                assoVid.append($(thisIframe))

            });

        })

</script>
