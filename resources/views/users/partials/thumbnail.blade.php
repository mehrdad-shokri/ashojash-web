@include('modals.upload-profile-photo')

<div class="row">
    <div class="col-xs-12 ">
        @include('users.partials.user-profile-pic')
    </div>
</div>
<div class="row">
    <div class="col-xs-12 top-xs-10">
        <h1>
            <a class="user-name"
               href="{{action('UsersController@show',$user->username)}}">{{$user->name}}</a>
        </h1>
    </div>
</div>
<div class="row ">
    <div class="col-xs-12 ltr">
        <span class="user-username ">{{"@" .$user->username}} </span>
    </div>
</div>
@if($user->bio)
    <div class="row top-xs-30 ">
        <div class="col-xs-12">
            <div class="user-bio text-muted">
                {{$user->bio}}</div>
        </div>
    </div>
@endif
@if($user->city)
    <div class="row top-xs-20">
        <div class="col-xs-12">
            @if($user->city)
                <div class="user-location top-xs-20 ">
                                <span class="icon ion-ios-location-outline" style="font-size:20px">
                                </span>
                    {{$user->city->name}}
                </div>
            @endif
        </div>
    </div>
@endif
<div class="row">
    <div class="col-xs-12 profile-btn-container top-xs-20">
        @if($currentUser)
            @if($currentUser->getKey()==$user->getKey())
                <div class="col-xs-12 p0"><a href="{{action("UsersController@settings")}}" class="c-btn">
                        <i class="fa fa-gear"></i>
                                                        <span class="profile-action-edit-span"
                                                              style="font-size: 13px;margin-left: 1px;margin-right: 3px">تنظیمات</span>
                    </a></div>
            @elseif($currentUser->getKey()!=$user->getKey())

                <div class="col-xs-12 p0 top-xs-10 social-primary-btn c-btn user-profile-follow-btn"
                     uId="{{$user->getKey()}}"
                     isFollowing="{{$currentUser->isFollowing($user)?'1':'0'}}">
                                                        <span class="profile-action-edit-span"
                                                              style="font-size: 13px;margin-left: 1px;">فالو</span>
                </div>
            @endif
        @else
            <a href="{{action("Auth\AuthController@getRegister")}}" class="hero-register" style="width: 220px">
                ثبت نام کنید تا بتوانید این کاربر را فالو کنید!
            </a>
        @endif
    </div>
</div>
@include('users.partials.user-stats')


{{--<div class="alert alert-danger" style="float: initial">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
</div>--}}
{{--
@include('layouts.partials.scripts.profile-dropzone')
--}}

