@extends('layouts.app')

@section('content')
    @foreach($friendshipRequests as $friendshipRequest)
        {{ $friendshipRequest->sender->username }}
        <accept-friendship-btn
            :sender="{{ $friendshipRequest->sender }}"
            friendship-status="{{ $friendshipRequest->status }}"
        ></accept-friendship-btn>
    @endforeach
@endsection
