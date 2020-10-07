@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-4">
                @foreach($friendshipRequests as $friendshipRequest)
                    <accept-friendship-btn
                        :sender="{{ $friendshipRequest->sender }}"
                        friendship-status="{{ $friendshipRequest->status }}"
                    ></accept-friendship-btn>
                @endforeach
            </div>
        </div>
    </div>
@endsection
