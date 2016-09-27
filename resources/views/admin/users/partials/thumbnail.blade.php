<div class="col-xs-12 col-sm-5 col-md-3 right white-bg shadow-1" style="border-radius: 10px">
    <div class="row">
        <div class="col-xs-12 ">
            <div class="col-xs-12 ">
                @if($currentUser)
                    @if($user->getKey()==$currentUser->getKey())
                        <a href="#" class="profile-img-link darken" id="upload_photo" data-toggle="modal"
                           data-target="#uploadPhotoModal">
                            @include('layouts.partials.user-avatar-normal')
                            <p class="text" style="display: inline">ویرایش تصویر</p></a>
                    @endif
                @else
                    @include('layouts.partials.user-avatar-normal')
                @endif

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 top-xs-10 rtl">
            <div class="col-xs-12">
                <h1>
                    <a class="user-name"
                       href="{{action('UsersController@show',$user->username)}}">{{$user->name}}</a>
                </h1>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-xs-12">
            <div class="col-xs-12 ltr">
                <span class="user-username right">{{"@" .$user->username}} </span>
            </div>
        </div>
    </div>
    @if($user->bio)
        <div class="row top-xs-30 rtl">
            <div class="col-xs-12">
                <div class="col-xs-12">
                    <div class="user-bio text-muted">
                        {{$user->bio}}</div>
                </div>
            </div>
        </div>
    @endif
    @if($user->city)
        <div class="row top-xs-20">
            <div class="col-xs-12">
                <div class="col-xs-12 ">
                    <div class="user-location right top-xs-20">
                                <span class="icon ion-ios-location-outline" style="font-size:20px">
                                </span>
                        {{$user->city->display_name}}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row top-xs-20 ">
        <div class="col-xs-12 profile-btn-container">
            @if($currentUser)

                <div class="col-xs-12 p0 top-xs-10 social-primary-btn c-btn user-profile-follow-btn btn-success"
                     data-user-id="{{$user->getKey()}}"
                     data-user-isbanned="{{($user->ban==0)?'0':'1'}}" id="banUser">
                                                        <span class="profile-action-edit-span"
                                                              style="font-size: 13px;margin-left: 1px;"></span>
                </div>

            @endif
        </div>
    </div>
    <div class="row top-xs-20 ">
        <div class="col-xs-12 faNum ">
            <div class=" user-stat-list text-muted">
                <a href="{{action("UsersController@reviews",$user->username)}}">
                    <div class="col-xs-4 user-stat"><strong>{{$user->reviews->count()}}</strong>

                        <div class="stat-name ">
                            <i class="fa fa-angle-left" style="font-size: 14px;"></i><span
                                    class="name">مرور</span></div>
                    </div>
                </a>
                <a href="{{action('UsersController@photos',$user->username)}}">
                    <div class="col-xs-4 user-stat"><strong>{{$photos->count()}}</strong>

                        <div class="stat-name ">
                            <i class="fa fa-angle-left" style="font-size: 14px;"></i><span
                                    class="name">عکس</span></div>
                    </div>
                </a>
                <a href="{{action("UsersController@followers",$user->username)}}">
                    <div class="col-xs-4 user-stat"><strong>{{$followers->count()}}</strong>

                        <div class="stat-name">
                            <i class="fa fa-angle-left" style="font-size: 14px;"></i><span
                                    class="name">فالوور</span></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
