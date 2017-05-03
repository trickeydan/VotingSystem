@extends('parts.template')
@section('title','Vote')
@section('content')
    @if($category != false)
        <h2 class="text-center">Vote: {{$category->title}}</h2>
        {!! Form::open(['role' => 'form', 'method' => 'post']) !!}
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <p class="text-center">Please select the person you would like to vote for {{$category->title}}.</p>
        <p class="text-center">Once submitted, your votes cannot be changed.</p>
        <div class="form-group text-center">
            {!! Form::label('chosen', 'Vote') !!}
            {!! Form::select('chosen',$list,null,['class' => 'selectpicker','data-live-search' => 'true']) !!}
        </div>
        <div class="form-group text-center">
            {!! Form::hidden('category',$category->id) !!}
            {!! Form::submit('Next',['class' => 'btn btn-success']) !!}
        </div>

        {!! Form::close() !!}
    @else
        <h2 class="text-center">Vote</h2>
        <p class="text-center">You have voted for somebody in all categories. Your votes cannot be changed at this point.</p>
        <p class="text-center">The following are your votes:</p>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Voted for</th>
                    </tr>
                </thead>
                <tbody>
                @if($votes->count() > 0)
                    @foreach($votes as $vote)
                        <tr>
                            <td>{{$vote->category->title}}</td>
                            <td>{{$vote->votee->name}}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            <p>There don't seem to be any categories. How strange!</p>
                        </td>
                    </tr>

                @endif
                </tbody>
            </table>
        </div>
    @endif

@endsection