@extends('layout')

@section('content')

<h1>Auction</h1>

<h3>Title: <strong>{{{ $data['auction']['auction_title'] }}} </strong></h3>
<p> creator: <strong>{{{ $data['auction']['creator_username'] }}}</strong> </p>
<p> min. price: <strong>{{{ $data['auction']['minimum_price'] }}}</strong> </p>
<p> created at: <strong>{{{ $data['auction']['date_created'] }}}</strong> </p>
<p> end date: <strong>{{{ $data['auction']['date_end'] }}}</strong> </p>
<p> description: <strong>{{{ $data['auction']['auction_desc'] }}}</strong> </p>
<p>  stars: <strong>{{{ $data['auction']['stars'] }}}</strong> / voters: (<strong>{{{ $data['auction']['voters'] }}}</strong>) </p>
<div>
    <h2>stars</h2> 
        {{ Form::open(array('url' => 'vote/auction/'.$data['auction']['auction_id'])) }}
        <!--<fieldset>-->
            <p>
                {{ Form::hidden('auction_id',$data['auction']['auction_id'] )}}
            </p>
            <!-- if errors, show them -->
            <p>
                {{ $errors->first('stars') }}
                {{ $errors->first('auction_id') }}
            </p>
            <p>
                {{ Form::label('stars', 'Rate:') }}
                {{ Form::text('stars', Input::old('stars'), array('placeholder' => '0...6')) }}
            </p>

            <p>{{ Form::submit('Add rating!') }}</p>
        <!--</fieldset>-->
        {{ Form::close() }}
    </div>
@if ($data['prices'])
<div>
    <h2> 
        winner: <strong>{{{ $data['prices'][0]['username'] }}}</strong> 
        price <strong>{{{$data['prices'][0]['price']}}}</strong> 
    </h2>
</div>
@endif

<div>
    <h1>Prices!</h1> 

    @foreach($data['prices'] as $price)
        <p>
            user: {{{  $price['username'] }}},
            price: {{{  $price['price'] }}}, 
            added: {{{ $price['date_created'] }}}. 
        </p>
    @endforeach
</div>
<div>
    <h1>Comments!</h1> 
    <div>
        {{ Form::open(array('url' => 'comment/auction/'.$data['auction']['auction_id'])) }}
        <!--<fieldset>-->
            <p>
                {{ Form::hidden('auction_id',$data['auction']['auction_id'] )}}
            </p>
            <!-- if errors, show them -->
            <p>
                {{ $errors->first('comment_title') }}
                {{ $errors->first('comment_text') }}
            </p>
            <p>
                {{ Form::label('comment_title', 'Title:') }}
                {{ Form::text('comment_title', Input::old('comment_title'), array('placeholder' => 'Title...')) }}
            </p>
            <p>
                {{ Form::label('comment_text', 'text:') }}
                {{ Form::text('comment_text', Input::old('comment_text'), array('placeholder' => 'text...')) }}
            </p>
            <p>{{ Form::submit('Add comment!') }}</p>
        <!--</fieldset>-->
        {{ Form::close() }}
    </div>

    @foreach($data['comments'] as $c)
        <p>
            user: {{{  $c['username'] }}},
            Title: {{{  $c['comment_title'] }}}, 
            Comment: {{{  $c['comment_text'] }}}, 
            added: {{{  $c['date_created'] }}}. 
        </p>
    @endforeach
</div>

@stop