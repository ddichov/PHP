@extends('layout')

@section('content')

<h1>Auction</h1>

<h3>Title: <strong>{{ $data->auction_title }} </strong></h3>
<p> min. price: <strong>{{ $data->minimum_price }}</strong> </p>
<p> end date: <strong>{{ $data->date_end }}</strong> </p>
<p> description: <strong>{{ $data->auction_desc }}</strong> </p>

<div>
    {{ Form::open(array('url' => 'bet/auction/'.$data->auction_id)) }}
    <fieldset>
        <p>
            {{ Form::hidden('auction_id',$data->auction_id )}}
        </p>
        <!-- if errors, show them -->
        <p>
            {{ $errors->first('price') }}
        </p>
        <p>
            {{ Form::label('price', 'offer price') }}
            {{ Form::text('price', Input::old('minimum_price'), array('placeholder' => 1)) }}
        </p>
        <p>{{ Form::submit('Submit!') }}</p>
    </fieldset>
    {{ Form::close() }}
</div>
<div>
    <a href="{{URL::to('auction')}}/{{$data->auction_id}}/details">Show full info</a>
   
</div>

@stop