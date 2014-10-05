@extends('layout')

@section('content')


{{ Form::open(array('url' => 'registration', 'class'=>'form-signup')) }}
    <h1>Registration</h1>

    <!-- if there are login errors, show them here -->
    <p>
        {{ $errors->first('name') }}
        {{ $errors->first('username') }}
        {{ $errors->first('email') }}
        {{ $errors->first('password') }}
    </p>

    <p>
        {{ Form::label('name', 'name') }}
        {{ Form::text('name', Input::old('name')) }}
    </p>
    <p>
        {{ Form::label('username', 'username') }}
        {{ Form::text('username', Input::old('username'), array('placeholder' => 'username')) }}
    </p>
    <p>
        {{ Form::label('email', 'Email Address') }}
        {{ Form::text('email', Input::old('email'), array('placeholder' => 'awesome@awesome.com')) }}
    </p>

    <p>
        {{ Form::label('password', 'Password') }}
        {{ Form::password('password') }}
    </p>
    <p>
        {{ Form::label('password_confirmation', 'Confirm password') }}
        {{ Form::password('password_confirmation') }}
    </p>

    <p>{{ Form::submit('Register!',array('class'=>'btn')) }}</p>
{{ Form::close() }}

@stop