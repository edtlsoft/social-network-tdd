@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card card border-0 bg-light shadow-sm">
                    <img src="{{ $user->avatar() }}" alt="" class="card-img-top">
                    <div class="card-body">
                        {{ $user->username }}
                        <friendship-btn
                            dusk="request-friendship"
                            :recipient="{{ $user }}"
                            friendship-status="{{ $friendshipStatus }}"
                            class="btn btn-primary"
                        ></friendship-btn>
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
