@if($currentUser)
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
           aria-expanded="false">{{$currentUser->name}} <span class="caret"></span></a>
        <ul class="dropdown-menu rtl ">

            <li class="user-profile"><a class="user-profile-text"
                                        href="{{action("UsersController@show",$currentUser->username)}}"><i
                            class="icon ion-ios-person-outline user-profile-icon"></i>پروفایل</a></li>
            <li class="user-profile"><a class="user-profile-text"
                                        href="{{action("UsersController@settings")}}"><i
                            class="icon ion-ios-gear-outline user-profile-icon"></i> تنظیمات</a></li>
            <li class="user-profile"><a class="user-profile-text"
                                        href="{{action("UsersController@reviews",$currentUser->username)}}">
                    <i class="icon ion-ios-compose-outline user-profile-icon"></i>مرورها</a></li>
            <li role="separator" class="divider"></li>
            <li class="user-profile">
                <form action="/logout" method="post">
                    {{csrf_field()}}
                    <i class="icon ion-log-out user-profile-icon"></i>
                    <input class="user-profile-text" type="submit" value="خروج" >
                </form>
            </li>
        </ul>
    </li>
@else
    <li><a href="/register">ثبت نام</a></li>
    <li><a href="/login">ورود</a></li>
@endif