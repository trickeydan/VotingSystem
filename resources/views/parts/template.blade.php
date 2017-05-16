<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{config('app.name')}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/flatly/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{asset('css/Footer-Basic.css')}}">
</head>

<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header"><a class="navbar-brand navbar-link" href="{{route('home')}}">{{config('app.name')}}</a>
            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        </div>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav">
                <li role="presentation"><a href="{{route('home')}}">Home</a></li>
                @if(Auth::Check() && Auth::User()->admin)
                    <li role="presentation"><a href="{{route('admin')}}">Control Panel</a></li>
                @else
                    @if(\App\System::mode() == \App\System::MODE_NOMINATE)
                        <li role="presentation"><a href="{{route('nominate')}}">Nominate</a></li>
                    @elseif(\App\System::mode() == \App\System::MODE_VOTE)
                        <li role="presentation"><a href="{{route('vote')}}">Vote</a></li>
                    @endif
                @endif
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li role="presentation"><a>{{Auth::User()->name}}</a></li>
                    <li role="presentation"><a href="{{route('logout')}}">Logout</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    @yield('content')
</div>
<div class="footer-basic">
    <footer>
        <ul class="list-inline">
            <li><a href="https://github.com/trickeydan/VotingSystem">Source</a></li>
            <li><a href="https://github.com/trickeydan/VotingSystem/blob/master/LICENSE">GPLv3</a></li>
        </ul>
        <p class="copyright">Dan Trickey © {{date('Y')}} | Version {{config('app.version')}}</p>
    </footer>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
</body>

</html>