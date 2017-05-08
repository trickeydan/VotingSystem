@extends('parts.template')
@section('title','Admin')
@section('content')
        <div class="jumbotron">
            <h1>Control Panel</h1>
            <p>Nomination Turnout: {{\App\System::getNominationTurnoutPercent()}}%</p>
            <p>Voting Turnout: {{\App\System::getVoteTurnoutPercent()}}%</p>
        </div>
@endsection