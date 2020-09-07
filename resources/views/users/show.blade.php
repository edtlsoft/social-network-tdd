@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card card border-0 bg-light shadow-sm">
                    <img src="{{ $user->avatar() }}" alt="" class="card-img-top">
                    <div class="card-body">
                        {{ $user->username }}
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card border-0 bg-light shadow-sm">
                    <div class="card-body">
                        Content
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
