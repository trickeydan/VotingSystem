@extends('parts.template')
@section('title','Home')
@section('content')
    @if(\App\System::mode() == \App\System::MODE_NOMINATE)
        <div class="jumbotron">
            <h1>Nomination Time!</h1>
            <p>It's time to nominate people for "most likely to".</p>
            <p><a class="btn btn-default" role="button" href="{{route('nominate')}}">Get Started!</a></p>
        </div>
    @elseif(\App\System::mode() == \App\System::MODE_VOTE)
        <div class="jumbotron">
            <h1>Voting Time!</h1>
            <p>It's time to vote for your nominees for "most likely to".</p>
            <p><a class="btn btn-default" role="button" href="#">Get Started!</a></p>
        </div>
    @else
        <div class="jumbotron">
            <h1>Waiting Time</h1>
            <p>Nominations and Voting are over.</p>
        </div>
    @endif
@endsection