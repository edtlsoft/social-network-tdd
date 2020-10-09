@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card card border-0 bg-light shadow-sm">
                    <img src="{{ $user->avatar() }}" alt="" class="card-img-top">
                    <div class="card-body">
                        @if(auth()->id() === $user->id)
                            <h5 class="card-title">{{ $user->username }} <small class="text-secondary">It's you</small></h5>
                        @else
                            <h5 class="card-title">{{ $user->username }}</h5>
                            <friendship-btn
                                dusk="request-friendship"
                                :recipient="{{ $user }}"
                                friendship-status="{{ $friendshipStatus }}"
                                class="btn btn-primary"
                            ></friendship-btn>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <status-list
                    url="{{ route('users.statuses.index', $user) }}"
                ></status-list>
            </div>
        </div>
    </div>

@endsection
