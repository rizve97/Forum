<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                   <i class="fa fa-user"></i> &nbsp; {{ Auth::user()->name }} <sup><span class="badge badge-danger">7</span></sup> <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="#" class="dropdown-item">
                                       <i class="fa fa-comments"></i> &nbsp; Messages <sup><span class="badge badge-success">2</span></sup>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                        <i class="fa fa-bell"></i> &nbsp; Notifications <sup><span class="badge badge-primary">5</span></sup>
                                    </a>
                                    <a href="#" class="dropdown-item">
                                       <i class="fa fa-user"></i> &nbsp; Profile
                                    </a>
                                    <hr>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <span style="color: red;"><i class="fa fa-power-off"></i></span> &nbsp; {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container-fulid">
                <div class="row">
                    <div class="col-md-4 justify-content-center">
                        <div class="card">
                            <div class="card-header text-center alert-info">
                                Channels
                            </div>
                            <div class="card-body">
                                <ul class="list-item-group text-center">
                                    @if(Auth::check())
                                        @if(Auth::user()->isAdmin)
                                            <a href="#">
                                                <li class="list-group-item alert alert-success">Dashboard</li>
                                            </a>
                                            <a href="{{route('channel.create')}}">
                                                <li class="list-group-item">Create Channel</li>
                                            </a>
                                            <hr>
                                        @endif
                                    @endif
                                    @if($channels)
                                        @foreach($channels as $channel)
                                            <a href="{{route('channel.show',['id' => $channel->id])}}">
                                                <li class="list-group-item">{{$channel->name}}</li>
                                            </a>
                                        @endforeach
                                    @endif
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 justify-content-center">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="{{asset('js/jquery.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    
    <script type="text/javascript">
        notifications();
        function notifications(stat)
        {
            var time = 5000;

            @if (session('success'))
                toastr.success("{{session('success')}}", 'Success', {timeOut: time})
            @elseif(session('error'))
                toastr.error("{{session('error')}}", 'Error', {timeOut: time})
            @elseif(session('warning'))
                toastr.warning("{{session('warning')}}", 'Warning', {timeOut: time})
            @elseif($errors->any())
                @foreach ($errors->all() as $message)
                    toastr.error("{{$message}}", 'Error', {timeOut: time += 500 })
                @endforeach
            @endif
            statusNotifications(stat,time);
        }


        function csrfAjaxToken()
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function statusNotifications(stat, time)
        {
            // if(stat == 200)
            // {
            //     toastr.success("OK", 'Success', {timeOut: time})  
            // }
            if(stat == 201)
            {
                toastr.success("Created", 'Success', {timeOut: time})
            }
            else if(stat == 401){
                toastr.error("You do not have enough permission",'Unauthorised', {timeOut : time})
            }
            else if(stat == 403)
            {
                toastr.error("Access Denied", 'Forbidden', {timeOut: time})
            }
            else if(stat == 404)
            {
                toastr.warning("Not Found", 'Not Found', {timeOut: time})
            }
            else if(stat == 500)
            {
                toastr.error("Server Problem, Not Your's", 'Server Error', {timeOut: time})
            }
        }
    </script>
    @yield('script')
</body>
</html>
