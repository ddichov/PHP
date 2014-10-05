<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title> myLaravel</title>
        <style>
            /*            .parallax{
                            background: url({{ URL::asset('static/blue_sky_and_green_grass.jpg') }}) 50% 0px no-repeat fixed;
                            background-size: 100%;
                            margin: 0;
                            height: 2000px;
                            position: absolute;
                            top: 0px;
                            left: 0;
                            width: 100%;
                            z-index: -1;
                        }
            
                        .parallax2 {
                            background: url({{ URL::asset('static/money_in_the_sky.jpg') }}) 100% 70px no-repeat fixed;
                            background-size: 100%;
                            margin: 0;
                            height: 1350px;
                            position: absolute;
                            top: 0px;
                            left: 0;
                            width: 100%;
                            opacity: 0.4;
                            filter: alpha(opacity=40);
                            z-index: -1;
                        }*/
        </style>
        <link rel="stylesheet" href="{{ URL::asset('static/style.css') }}">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="{{ URL::asset('static/scrolly.js') }}"></script>
    </head>
    <body>

        <div class="nav-wrapper">
            <header class="clearfix">
                <div class="row clearfix">
                    <div class="logo">Auction Store</div>
                    @if(Auth::check())
                    <div class="hello">Hello {{{Auth::user()->username}}}!</div>
                    <a href="http://mylaravel/logout">Logout</a>
                    <a href="http://mylaravel/users">Users</a>

                    @else
                    <a href="{{ URL::to('auction') }}">Auctions</a>
                    <a href="{{ URL::to('login') }}">Login</a>
                    <a href="{{ URL::to('registration') }}">Registration</a> 
                    @endif
                </div>
                <ul class="nav">  

                    @if(Auth::check())
                    <li><a href="{{ URL::to('auction') }}">Auctions</a> </li>
                    <li><a href="{{ URL::to('add/auction') }}">add auction</a> </li>
                    <li><a href="{{ URL::to('my/auction') }}">My auctions</a> </li>
                    @else
                    <li><a href="{{ URL::to('auction') }}">Auctions</a> </li>
                    @endif
                </ul> 

            </header>
        </div>

        <div class="wrapper">
            <div class="parallax sky"  data-velocity="-.1" data-fit="0"></div>
            <div class="parallax money"  data-velocity=".15" data-fit="0" data-startx="20"></div>
            <div class="parallax dove" data-velocity="-.32" data-fit="400" data-startx="80"></div>
            <div class="wrap1">
                <div class="content">
                    @if(null !== Session::get('message'))
                    <p class="alert-s">{{ Session::get('message') }}</p>
                    @endif

                    @yield('content')
                </div>
            </div>

            <div class="wrap_footer">
                <div class="footer">
                    <h3>made by Dilyan</h3>
                    <h3>( Php 5.5, Laravel 4, Eloquent, MySQL, Blade Templating )</h3>
                </div>
            </div>
        </div>
        <script type="text/javascript">
$(document).ready(function() {
    $('.parallax').scrolly({bgParallax: true});
});
        </script>
    </body>
</html>

