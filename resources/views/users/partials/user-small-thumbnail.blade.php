<div class="col-xs-12 top-xs-20 ">
    <div class="col-xs-3 ">
        @if($currentUser)
            @if($currentUser->getKey()!=$user->getKey())
                <span class="top-xs-5 user-follow-btn" id="user-{{$user->getKey()}}" data-uId="{{$user->getKey()}}"
                      data-isFollowing="{{$currentUser->isFollowing($user)?'1':'0'}}">
                 @if($currentUser->isFollowing($user))
                        <i class="icon ion-checkmark-round"></i>
                    @else
                        <i class="icon ion-ios-personadd-outline"></i>
                    @endif
                 </span>
            @endif
        @endif
    </div>

    <div class="col-xs-6 col-sm-7 col-md-6">
        <div class="row"><a href="{{action("UsersController@show",$user->username)}}" style="color: #404040;"><h5
                        class="right right-xs-10 rtl" style="font-weight: 700">{{$user->name}}</h5></a></div>
        <div class="row text-muted faNum" style="margin-right: 0;font-size: 13px;">
            <span>
            {{$user->followers()->count()}}
                فالوور
            </span>
            <span> &nbsp;,
                {{$user->reviews()->count()}}
                مرور
            </span>
        </div>
    </div>
    <div class="col-xs-2">
        <div class="row"><a href="{{action("UsersController@show",$user->username)}}"
                            style="color: #404040;">@include('layouts.partials.user-avatar-small')</a></div>
    </div>
</div>