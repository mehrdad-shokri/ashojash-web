<div class="tab-bar stick-to-navbar" id="venue-tab-bar">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="pull-left {{UI::activeMenu('info')}}"><a
                        href="{{action('BusinessOwner\VenuesController@info',$venue->slug)}}">اطلاعات</a></li>
            <li class="pull-left {{UI::activeMenu('photo')}}"><a
                        href="{{action('BusinessOwner\VenuesController@getPhoto',$venue->slug)}}">تصویر</a></li>
            <li class="pull-left {{UI::activeMenu('map')}}"><a
                        href="{{action('BusinessOwner\VenuesController@getMap',$venue->slug)}}">نقشه</a></li>
            <li class="pull-left {{UI::specialActiveMenu('menu')}}"><a
                        href="{{action('BusinessOwner\MenusController@all',$venue->slug)}}">منو</a></li>
            <li class="pull-left {{UI::activeMenu('schedules')}}"><a
                        href="{{action('BusinessOwner\VenuesController@schedules',$venue->slug)}}">ساعات کار</a></li>
            <li class="pull-left {{UI::activeMenu('reviews')}}"><a
                        href="{{action('BusinessOwner\VenuesController@reviews',$venue->slug)}}">نظرات</a></li>
            <li class="pull-left {{UI::activeMenu('support')}}"><a
                        href="{{action('BusinessOwner\VenuesController@support',$venue->slug)}}">پشتیبانی</a></li>
            <li class="pull-left {{UI::activeMenu('suggestion')}}"><a
                        href="{{action('BusinessOwner\VenuesController@suggestion',$venue->slug)}}">پیشنهادات</a></li>
            @if(Auth::user()->hasRole('admin'))
                <li class="pull-left {{UI::activeMenu('json')}}"><a
                            href="{{action('Admin\VenuesController@json',$venue->slug)}}">json</a>
                </li>

            @endif
        </ul>
    </div>
</div>