@if($currentUser)
    @role((['admin','content-provider','biz-owner']))
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
           aria-expanded="false">مدریت <span class="caret"></span></a>
        <ul class="dropdown-menu rtl ">
            @permission(('manage-user'))
            <li class="user-profile"><a class="user-profile-text"
                                        href="{{action('Admin\UsersController@all')}}"><i
                            class="icon ion-ios-settings user-profile-icon"></i>
                    مدریت </a>
            </li>
            <li role="separator" class="divider"></li>
            @endrole

            @permission(('manage-tag'))
            <li class="user-profile"><a class="user-profile-text"
                                        href="{{action('Admin\TagsController@all')}}"><i
                            class="icon ion-edit user-profile-icon"></i>
                    مدریت محتوا </a>
            </li>
            @endpermission
            @if(Auth::user()->venuesOwned->count()>0)
                <li role="separator" class="divider"></li>
                <li class="user-profile"><a class="user-profile-text"
                                            href="{{action('UsersController@venues')}}"><i
                                class="icon ion-android-restaurant user-profile-icon"></i>
                        صاحبان کسب و کار
                    </a>
                </li>
            @endif
        </ul>
    </li>
    @endrole
@endif