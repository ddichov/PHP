@extends('layout')

@section('content')

<h1>Create Auction</h1> 

{{ Form::open(array('url' => 'add/auction')) }}

    <!-- if there are login errors, show them here -->
    <p>
        {{ $errors->first('auction_title') }}
        {{ $errors->first('minimum_price') }}
        {{ $errors->first('date_end') }}
    </p>

    <p>
        {{ Form::label('auction_title', 'title') }}
        {{ Form::text('auction_title', Input::old('auction_title'), array('placeholder' => 'auction_title')) }}
    </p>

    <p>
        {{ Form::label('minimum_price', 'Price') }}
        {{ Form::text('minimum_price', Input::old('minimum_price'), array('placeholder' => 1)) }}
    </p>

    <p>
        {{ Form::label('date_end', 'date_end') }}
        {{ Form::text('date_end', Input::old('date_end')) }}
    </p>
    <p>
        {{ Form::label('auction_desc', 'auction_description') }}
        {{ Form::text('auction_desc') }}
    </p>

    <p>{{ Form::submit('Submit!') }}</p>
{{ Form::close() }}


@stop

