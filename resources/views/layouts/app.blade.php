<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cric8pro') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Cric8pro') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            @if(Auth::guard('admin')->check())
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Users  <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                        @if(session()->has('perms'))
                                            @foreach(Session::get("perms") as $per)
                                            @if($per=="UsersBioController.index")
                                            <a href="{{ route('userBio.index') }}">Bio</a>
                                            @elseif($per=="UserCricketProfileController.index")
                                            <a href="{{ route('criProfile.index') }}">Cricket Profile</a>
                                            @elseif($per=="OrganizationMasterController.index")
                                            <a href="{{ route('org.index') }}">Org Bio</a>
                                            @endif
                                            @endforeach
                                        @endif
                                            <a href="/">home</a>
                                        </li>
                                    </ul>
                                </li>
                            @elseif(Auth::user()->role == "organizer")
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Master's  <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('User.bulkUploadView') }}">Bulk Upload</a>
                                            <a href="{{ route('tourmst.index') }}">Tournament's</a>
                                            <a href="{{ route('team.index') }}">Team's</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <li >

                            </li>
                            <li class="dropdown">

                                <a href="#" class="dropdown-toggle" style="padding-right: 50px" data-toggle="dropdown" role="button" aria-expanded="false">
                                    @if (Session::has('user_img'))
                                        <img src ="{{asset('images/'.Session::get('user_img'))}}" width="32px" class="img-rounded"/>
                                    @else
                                        <img src ="{{asset('images/default128_128.png')}}" width="32px" class="img-rounded"/>
                                    @endif
                                    {{ Auth::user()->email}} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                      @if(Auth::check())
                                        <a href="{{ route('profile.show',Auth::user()->user_master_id) }}"><b>Profile</b></a>
                                      @else
                                        <a href="{{ route('profile.showUser',Auth::guard('admin')->user()->user_master_id) }}"><b>Profile</b></a>
                                      @endif
                                        <div role="separator" class="divider"></div>
                                        <a href="/pass/request">Change Pass</a>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}"></script>-->
</body>
</html>
