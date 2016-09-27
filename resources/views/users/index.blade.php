@extends('layout')

@section('content')
    <div class="row">
        <h1 class="text-center">All Users</h1>
        @foreach($users->chunk(4) as $userSet)
            <div class="row users">
                @foreach($userSet as $user)
                    <div class="col-md-3 user-block rtl">
                        <a style="display: block;" href="{{action('UsersController@show',['username'=>str_replace(' ','-',$user->username)])}}">
                            @include('users.partials.avatar',['username'=>$user->username,'classes'=>'img-circle','email'=>$user->email,'size'=>'70'])
                            <h4 class="user-block-username">
                                {{$user->name}}
                            </h4>
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
        {!! $users->render() !!}

    </div>
@stop