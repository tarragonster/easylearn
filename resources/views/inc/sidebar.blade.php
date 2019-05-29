<link rel="stylesheet" href="{{asset('css/sidebar.css')}}" type="text/css">

<div id="mySidenav" class="sidenav shadow">

    @if(Auth::check())
        <div id="div-btn">
            <button id="createButton" type="button" data-toggle="dropdown" aria-expanded="true" class="shadow-sm rounded">Create</button>
            <ul class="dropdown-menu outer-component sidebar-bits">
                <li class="sidebar-component" data-toggle="modal" data-target="#sidebar-modal">Post with images</li>
                <li class="sidebar-component" data-toggle="modal" data-target="#video-modal">Post with videos</li>
            </ul>
        </div>
        <div class="outer-title-lists">
            <p id="title-lists">WORD LISTS</p>
        </div>

        <div class="outerListSidebar">
            @if(count($sidebars)>0)
                @foreach($sidebars as $sidebar)
                    <div id="div-link">
                        <h3 class="contain-link"><a class="side-link" href="/lists/{{$sidebar->list}}/practice/{{Auth::user()->id}}"><i
                                    class="fas fa-folder"></i> {{$sidebar->list}}</a></h3>
                    </div>
                @endforeach

                    <div class="dict-search-sidebar" style="display: none">
                        <p id="title-lists" class="list-dict">DICTIONARY SEARCH</p>

                        <div class="search-inner search-inner-sidebar">

                            {!! Form::open(['action'=>'DictionariesController@search','method'=>'GET','class'=>'search-form']) !!}

                            <div class="input-group">

                                {{Form::text('q',$q,['class'=>'form','placeholder'=>'Search'])}}

                                {{Form::select('language', ['E' => 'English', 'K' => 'Korean'],$selectOption,['class'=>'btn-select dropdown-toggle'])}}

                                {{Form::button('<i class="fas fa-search"></i>',['class'=>'btn-search d-none','type'=>'submit'])}}

                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
            @else
                <p>No lists found</p>
            @endif
            @else
                <div class="list-group-item login-outer-btn">
                    <a class="nav-link login-btn" href="{{ route('login') }}">{{ __('LOGIN') }}</a>
                </div>

                <div class="dict-search-sidebar" style="display: none">
                    <p id="title-lists" class="list-dict">DICTIONARY SEARCH</p>

                    <div class="search-inner search-inner-sidebar">

                        {!! Form::open(['action'=>'DictionariesController@search','method'=>'GET','class'=>'search-form']) !!}

                        <div class="input-group">

                            {{Form::text('q',$q,['class'=>'form','placeholder'=>'Search'])}}

                            {{Form::select('language', ['E' => 'English', 'K' => 'Korean'],$selectOption,['class'=>'btn-select dropdown-toggle'])}}

                            {{Form::button('<i class="fas fa-search"></i>',['class'=>'btn-search d-none','type'=>'submit'])}}

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endif
        </div>
</div>

<div class="main-outer">
    <div id="main">

        @yield('content')
    </div>
</div>

@include('inc.sidebar_images')
@include('inc.sidebar_videos')

<script>
    $(document).ready(function () {
        $('.menu').click(function () {
            $('#mySidenav').toggleClass('sidebar-active')
        })
    })

    $(document).mouseup(function (e) {

        if (!$('.menu').is(e.target) && $('.menu').has(e.target).length === 0
            && !$('#mySidenav').is(e.target) && $('#mySidenav').has(e.target).length === 0) {
            $('#mySidenav').attr('class', 'sidenav shadow');

        }
    })



</script>
