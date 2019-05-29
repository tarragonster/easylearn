<link rel="stylesheet" href="{{asset('css/navbar.css')}}" type="text/css">

<nav class="topbar">

        <div class="title-outer">

            <div class="toggle">
                <i class="fas fa-bars menu"></i>
            </div>

            <a class="brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>

        <div class="navbar-container" id="navbarSupportedContent">

            <ul class="navbar-outer left-ele" id="left-ele">
                <li class="nav-item shadow-sm rounded">
                    <a class="click-link right-link shadow-sm rounded" href="/">HOME</a>
                </li>
                <li class="nav-item shadow-sm rounded">
                    <a class="click-link right-link shadow-sm rounded" href="/postVideo/show">VIDEOS</a>
                </li>
                <li class="nav-item shadow-sm rounded">
                    <a class="click-link right-link shadow-sm rounded" href="/postImage/show">ARTICLES</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <div class="accessLists shadow-sm">
                <i class="fas fa-caret-down inner-accessList shadow-sm"></i>
            </div>
            <ul class="navbar-outer right-ele">
                <!-- Authentication Links -->
                @guest
                    <div class="accessLogins">
                        <i class="fas fa-sign-in-alt inner-accessLogin shadow-sm"></i>
                    </div>

                <ul class="navbar-outer left-ele" id="right-ele">
                    <li class="nav-item shadow-sm rounded">
                        <a class="click-link unlogin-nav shadow-sm rounded" href="{{ route('login') }}">{{ __('LOGIN') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item shadow-sm rounded">
                            <a class="click-link unlogin-nav shadow-sm rounded" href="{{ route('register') }}">{{ __('REGISTER') }}</a>
                        </li>
                    @endif
                </ul>

                @else

                    <li class="nav-item dropdown top-dd shadow-sm">
                            <a class="click-link icon-user shadow-sm" data-toggle="dropdown" href="" role="button">
                                <span class="inner-link">{{ Auth::user()->name }}</span>
                                <i class="fas fa-user currentUser"></i>
                            </a>

                        <div class="dropdown-menu user-menu">

                            <div class="user-item">
                                <a class="click-link user-link" href="/user/account">ACCOUNT</a>
                            </div>

                            <div class="user-item">
                                <a class="dropdown-item click-link  user-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('LOGOUT') }}
                                </a>
                            </div>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
</nav>

<script>

    $(document).ready(function () {


    })

    $(document).mouseup(function (e) {

        if (!$('.accessLists').is(e.target) && $('.accessLists').has(e.target).length === 0)
        {

            $('#left-ele').attr('class','navbar-outer left-ele');
            resetButton($('.accessLists'));

        }

        if(!$('.accessLogins').is(e.target) && $('.accessLogins').has(e.target).length === 0)
        {
            $('#right-ele').attr('class','navbar-outer left-ele');
            resetButton($('.accessLogins'));
        }
    });


        $('.accessLists').click(function () {

            $('#left-ele').toggleClass('theActive');

            if($('#left-ele').attr('class')!=='navbar-outer left-ele'){
                $(this).find('i').css('color', '#BB9A81');
                $(this).css('background-color', '#49463D');
                $(this).find('i').css('background-color', '#49463D');

                $(this).hover(function () {
                    $(this).find('i').css('color', '#BB9A81');
                    $(this).css('background-color', '#49463D');
                    $(this).find('i').css('background-color', '#49463D');
                }, function () {
                    $(this).find('i').css('color', '#BB9A81');
                    $(this).css('background-color', '#49463D');
                    $(this).find('i').css('background-color', '#49463D');
                })

            }else{
                resetButton($(this))
            }

            resetButton($('.accessLogins'));
            $('#right-ele').attr('class','navbar-outer left-ele')
        })

        $('.accessLogins').click(function () {

            $('#right-ele').toggleClass('theActive');

            if($('#right-ele').attr('class')!=='navbar-outer left-ele') {
                $(this).find('i').css('color', '#BB9A81');
                $(this).css('background-color', '#49463D');
                $(this).find('i').css('background-color', '#49463D');

                $(this).hover(function () {
                    $(this).find('i').css('color', '#BB9A81');
                    $(this).css('background-color', '#49463D');
                    $(this).find('i').css('background-color', '#49463D');
                }, function () {
                    $(this).find('i').css('color', '#BB9A81');
                    $(this).css('background-color', '#49463D');
                    $(this).find('i').css('background-color', '#49463D');
                });
            }else{
                resetButton($(this))
            }

            resetButton($('.accessLists'));
            $('#left-ele').attr('class','navbar-outer left-ele')
        });

    function resetButton(input){

        input.find('i').css('color', '#49463D');
        input.css('background-color', '#A39F8B');
        input.find('i').css('background-color', '#A39F8B');

        input.hover(function () {
            input.find('i').css('color', '#D1CBB3');
            input.css('background-color', '#49463D');
            input.find('i').css('background-color', '#49463D');
        }, function () {
            input.find('i').css('color', '#49463D');
            input.css('background-color', '#A39F8B');
            input.find('i').css('background-color', '#A39F8B');
        })
    }


</script>
