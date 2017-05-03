@extends('parts.template')
@section('title','Nominate')
@section('content')
    @if($category != false)
        <h2 class="text-center">Nominate: {{$category->title}}</h2>
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
        <p class="text-center">Please select the person you would like to nominate for {{$category->title}}.</p>
        <p class="text-center">Once submitted, your nominations cannot be changed.</p>
        <div class="form-group text-center">
            {!! Form::label('chosen', 'Nominate') !!}
            {!! Form::select('chosen',$list,null,['class' => 'selectpicker','data-live-search' => 'true']) !!}
        </div>
        <div class="form-group text-center">
            {!! Form::hidden('category',$category->id) !!}
            {!! Form::submit('Next',['class' => 'btn btn-success']) !!}
        </div>

        {!! Form::close() !!}
    @else
        <h2 class="text-center">Nominate</h2>
        <p class="text-center">You have nominated somebody in all categories. Your nominations cannot be changed at this point.</p>
        <p class="text-center">The following are your nominees:</p>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Category</th>
                    <th>Nomination</th>
                </tr>
                </thead>
                <tbody>
                @if($nominations->count() > 0)
                    @foreach($nominations as $nomination)
                        <tr>
                            <td>{{$nomination->category->title}}</td>
                            <td>{{$nomination->nominee->name}}</td>
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