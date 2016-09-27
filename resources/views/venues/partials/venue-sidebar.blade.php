<div class="row venue-info-group">
    <div class="col-xs-12 ">
        <h4>شماره تماس</h4>
        @if($venue->phone)
            <p class="venue-phone-num faNum">
                {{substr($venue->phone,0,3)}}
                -{{substr($venue->phone,3,strlen($venue->phone))}}
            </p><br>
        @else
            <p class="text-muted">
                شماره تماسی یافت نشد.
                <span class="icon ion-sad-outline"></span>
            </p>
        @endif
    </div>
    <div class="col-xs-12 top-xs-10">
        <h4>آدرس</h4>
        @if($venue->location->address)
            <address class="venue-address">{{$venue->location->address}}
            </address>
        @else
            <p class="text-muted">
                آدرسی یافت نشد.
                <span class="icon ion-sad-outline"></span>
            </p>
        @endif

    </div>
    @if($venue->location->lat & $venue->location->lng)
        <div class="col-xs-12 top-xs-20">
            <div id="g-map" style="height:200px"></div>
        </div>
    @endif
    <div class="col-xs-12 top-xs-20">
        <h4 style="display: inline" class="left-xs-5">
            ساعات کار
        </h4>
        @if($schedules->count()!=0)
            <span class="res-timings-toggle" id="res-timings-toggle">
            ( بیشتر ببینید +)
        </span>
            @include('venues.partials.working-hours')
        @else
            <p class="text-muted">
                ساعات کاری برای این رستوران یافت نشد.
                <span class="icon ion-sad-outline"></span>
            </p>
        @endif

    </div>
    <div class="col-xs-12 top-xs-20">
        <h4 style="" class="">خوراک</h4>
        @if($venue->cuisines->count()!=0)
            @include('venues.partials.venue-cuisine')
        @else
            <p class="text-muted">
                ساعات کار برای این رستوران
                اضافه نشده.
                <span class="icon ion-sad-outline"></span>
            </p>
        @endif
    </div>
    <div class="col-xs-12 top-xs-20">
        <h4>قیمت</h4>

        <div>
            @include('venues.partials.venue-cost')
        </div>
    </div>
    <div class="col-xs-12 faNum">
        <div class="col-xs-12 top-xs-40">
            <div class=" venue-stat-list text-muted">
                <a href="{{action("VenuesController@photos",$venue->slug)}}">
                    <div class="col-xs-6 venue-stat"><strong>{{$photosCount}}</strong>

                        <div class="stat-name ">
                          <span class="name">
                                عکس
                            </span> <i class="fa fa-angle-left" style="font-size: 14px;"></i></div>
                    </div>
                </a>
                {{--    <a href="{{action('VenuesController@reviews',$venue->slug)}}">--}}
                <a href="#reviews">
                    <div class="col-xs-6 venue-stat" style="border-right: none;"><strong>{{$reviews->count()}}</strong>

                        <div class="stat-name ">
                           <span class="name">
                                مرور
                            </span> <i class="fa fa-angle-left" style="font-size: 14px;"></i></div>
                    </div>
                </a>

            </div>
        </div>
    </div>
    <div class="col-xs-12 top-xs-30">
        <a href="" class="top-xs-5 dis-block"> گزارش ایراد</a>
        <a href="" class="top-xs-5 dis-block"> ویرایش اطلاعات</a>
        <a href="{{action("VenuesController@getClaim",array($venue->location->city->slug,$venue->slug))}}"
           class="top-xs-5 dis-block">آیا این کسب و کار شماست؟ اختیار آن را به دست بگیرید</a>
    </div>
</div>