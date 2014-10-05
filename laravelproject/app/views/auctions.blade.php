@extends('layout')

@section('content')
    <h1>Auctions available!</h1>
    <ul>
        @foreach($data as $auc)
        <li>
            <span>
                {{{ $auc->auction_title }}}, 
                price: {{ $auc->minimum_price }},
                till: {{{  $auc->date_end }}}. 
            </span>
            <a href="{{URL::to('auction')}}/{{$auc->auction_id}}"> contest </a> , 
            <a href="{{URL::to('auction')}}/{{$auc->auction_id}}/details">View details</a>
        </li>
        @endforeach
    </ul>
@stop