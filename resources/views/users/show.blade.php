@extends('layout')

@section('content')
    <div class="row">
        <div class="col-xs-3"></div>
        @include('users.partials.avatar',['username'=>$user->username,'classes'=>'img-circle','email'=>$user->email,'size'=>'70'])
        <h6 class="text-muted">{{$user->username}}</h6>
        <h4>{{$user->name}}</h4>
        @include('users.partials.follow-form')
    </div>
    <div class="col-xs-9"></div>

    {{-- show usernam,Followers,Following,etc--}}
    </div>
@stop