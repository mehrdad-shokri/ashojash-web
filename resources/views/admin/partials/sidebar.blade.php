<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{action("PhotosController@getUserAvatar",$currentUser->username)}}" class="img-circle"
                     alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{$currentUser->name}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu rtl">
            <li class="header text-center">پنل مدریت</li>
            <!-- Optionally, you can add icons to the links -->
        @permission(('manage-user'))
        <!-- Users part -->
            <li class="{{UI::activeMenu('user')}} "><a href="{{action('Admin\UsersController@all')}}"><i
                            class="fa fa-link"></i><span>کاربران</span></a></li>
        @endpermission
        @permission(('manage-city'))
        <!-- Cities part -->
            <li class="treeview {{UI::activeMenu('city')}}">
                <a href="#"><i class="fa fa-share"></i><span>شهر</span> <i
                            class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu ">
                    <li class="{{UI::activeMenu('city/all')}}"><a href="{{action('Admin\CitiesController@all')}}"><i
                                    class="fa fa-link"></i> <span>لیست</span></a></li>
                    <li class="{{UI::activeMenu('city/create')}}"><a href="{{action('Admin\CitiesController@create')}}"><i
                                    class="fa fa-link"></i> <span>جدید</span></a></li>
                </ul>
            </li>
            @endpermission
            @permission(('manage-venue'))
            {{-- Venues part --}}
            <li class="treeview {{UI::activeMenu('venue')}}">
                <a href=""><i class="fa fa-share"></i><span>کسب‌وکار</span><i
                            class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{UI::activeMenu('venue/all')}}"><a href="{{action('Admin\VenuesController@all')}}"><i
                                    class="fa fa-link"></i><span>لیست</span></a></li>
                    {{--  <li class="{{UI::activeMenu('venue/create')}}"><a
                                  href="{{action('Admin\VenuesController@create')}}"><i class="fa fa-link"></i><span>Create</span></a>
                      </li>--}}
                    <li class="{{UI::activeMenu('venue/pending')}}"><a
                                href="{{action('Admin\VenuesController@pending')}}"><i class="fa fa-link"></i><span>انتظار</span></a>
                    </li>
                    <li class="{{UI::activeMenu('venue/create')}}"><a
                                href="{{action('Admin\VenuesController@create')}}"><i
                                    class="fa fa-link"></i><span>جدید</span></a>
                    </li>
                </ul>
            </li>
            @endpermission
            @permission(('manage-role'))

        <!-- Authorization Role-->
            <li class="treeview {{UI::activeMenu('role')}}">
                <a href=""><i class="fa fa-share"></i><span>نقش</span><i
                            class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{UI::activeMenu('cuisine/all')}}"><a href="{{action('Admin\RolesController@all')}}"><i
                                    class="fa fa-link"></i><span>لیست</span></a></li>
                    <li class="{{UI::activeMenu('cuisine/create')}}"><a
                                href="{{action('Admin\RolesController@create')}}"><i
                                    class="fa fa-link"></i><span>جدید</span></a>
                    </li>
                </ul>
            </li>
            @endpermission
            @permission(('manage-collection'))
        <!-- Tags Part -->
            <li class="treeview {{UI::activeMenu('collecttion')}}">
                <a href=""><i class="fa fa-share"></i><span>کلکسیون</span><i
                            class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{UI::activeMenu('tag/all')}}"><a
                                href="{{action('Admin\CollectionsController@all')}}"><i
                                    class="fa fa-link"></i><span>لیست</span></a></li>
                    <li class="{{UI::activeMenu('tag/create')}}"><a
                                href="{{action('Admin\CollectionsController@create')}}"><i
                                    class="fa fa-link"></i><span>جدید</span></a>
                    </li>
                </ul>
            </li>
            @endpermission
            @permission(('manage-tag'))
        <!-- Tags Part -->
            <li class="treeview {{UI::activeMenu('tag')}}">
                <a href=""><i class="fa fa-share"></i><span>تگ</span><i
                            class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{UI::activeMenu('tag/all')}}"><a
                                href="{{action('Admin\TagsController@all')}}"><i
                                    class="fa fa-link"></i><span>لیست</span></a></li>
                    <li class="{{UI::activeMenu('tag/create')}}"><a
                                href="{{action('Admin\TagsController@create')}}"><i
                                    class="fa fa-link"></i><span>جدید</span></a>
                    </li>
                </ul>
            </li>
            @endpermission
            @permission(('manage-cuisine'))
        <!-- Cuisines Part -->
            <li class="treeview {{UI::activeMenu('cuisine')}}">
                <a href=""><i class="fa fa-share"></i><span>ضاعقه</span><i
                            class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{UI::activeMenu('cuisine/all')}}"><a
                                href="{{action('Admin\CuisinesController@all')}}"><i
                                    class="fa fa-link"></i><span>لیست</span></a></li>
                    <li class="{{UI::activeMenu('cuisine/create')}}"><a
                                href="{{action('Admin\CuisinesController@create')}}"><i
                                    class="fa fa-link"></i><span>جدید</span></a>
                    </li>
                </ul>
            </li>
            @endpermission
            @permission(('manage-feature'))
        <!-- Features section-->
            <li class="treeview {{UI::activeMenu('feature')}}">
                <a href=""><i class="fa fa-share"></i><span>امکانات</span><i
                            class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{UI::activeMenu('feature/all')}}"><a
                                href="{{action('Admin\FeaturesController@all')}}"><i
                                    class="fa fa-link"></i><span>لیست</span></a></li>
                    <li class="{{UI::activeMenu('feature/create')}}"><a
                                href="{{action('Admin\FeaturesController@create')}}"><i
                                    class="fa fa-link"></i><span>جدید</span></a>
                    </li>
                </ul>
            </li>
            @endpermission
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>