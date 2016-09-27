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