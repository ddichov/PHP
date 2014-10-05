@extends('layout')

@section('content')
<h1>My Auctions!</h1>
<ul>
    @foreach($data as $auc)
    <li>
        <a href="{{URL::to('auction')}}/{{$auc->auction_id}}">  
            <span>{{ $auc->auction_title }} => {{ $auc->minimum_price }} </span>
        </a> , 
        <a href="{{URL::to('auction')}}/{{$auc->auction_id}}/details">View details</a>
    </li>
    @endforeach
</ul>
@stop