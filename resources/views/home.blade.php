@extends('parts.template')
@section('title','Home')
@section('content')
    @if(\App\System::mode() == \App\System::MODE_NOMINATE)
        <div class="jumbotron">
            <h1>Nomination Time!</h1>
            <p>It's time to nominate for {{config('app.reason')}}.</p>
            <p><a class="btn btn-default" role="button" href="{{route('nominate')}}">Get Started!</a></p>
        </div>
    @elseif(\App\System::mode() == \App\System::MODE_VOTE)
        <div class="jumbotron">
            <h1>Voting Time!</h1>
            <p>It's time to vote for your nominees for "most likely to".</p>
            <p><a class="btn btn-default" role="button" href="{{route('vote')}}">Get Started!</a></p>
        </div>
    @elseif(\App\System::mode() == \App\System::MODE_FINISH)
        <div class="jumbotron">
            <h1>Voting is now finished.</h1>
            <p>Nominations and Voting are over.</p>
        </div>
    @else
        <div class="jumbotron">
            <h1>System Unavailable</h1>
            <p>The voting system is currently unavailable.</p>
        </div>
    @endif
@endsection