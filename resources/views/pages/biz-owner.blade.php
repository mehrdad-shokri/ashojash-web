@extends('layout')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg p0 stick-to-navbar">
            <div class="row">
                <div class="col-xs-12">
                    <h1 class="text-center biz-welcome top-xs-60">به بخش صاحبان کسب و کار خوش آمدید</h1>

                    <div class="biz-form-title top-xs-20">امکاناتی که به پیشرفت کسب و کارتان کمک می کنند</div>
                </div>
                <div class="col-xs-12 top-xs-40">
                    <div class="col-xs-12 col-sm-4">
                        <img src="{{asset("img/collection/business-marketing-logo-2.jpg")}}" alt="Ashojash logo"
                             class="biz-logo">

                        <p class="text-muted col-xs-6 col-xs-offset-3 top-xs-20 text-center">تمام اطلاعات کسب و کارتان
                            در محیطی راحت مدریت کنید.</p>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <img src="{{asset("img/collection/business-marketing-logo-3.jpg")}}" alt="Ashojash logo"
                             class="biz-logo">

                        <p class="text-muted col-xs-6 col-xs-offset-3 top-xs-20 text-center">با به روز نگه داشتن اطلاعات
                            کسب و کارتان همیشه برای کاربران در دسترس باشید.</p>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <img src="{{asset("img/collection/business-marketing-logo-4.jpg")}}" alt="Ashojash logo"
                             class="biz-logo">

                        <p class="text-muted col-xs-6 col-xs-offset-3 top-xs-20 text-center">منو رستوران خود را اضافه
                            کنید و کسب و
                            کارتان را متمایز از بقیه نمایید.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row right-xs-0 left-xs-0" style="background-color: #e0e0e0">
            <h1 class="text-center">چیزی را که مال شماست به دست بیاورید.</h1>
            @include('pages.partials.search-venue')
        </div>
        <div class="light-gray-bg">
            <div class="row ">
                <div class="col-xs-12">
                    <h1 class="text-center">پنل کنترلی ساده و راحت</h1>

                    <div class="features-screenshot-container">
                        <div class="features-img-crop-container ">
                            <img src="{{asset("img/collection/biz-owners/snapshots/ashojash-dashboard-2.jpg")}}" alt=""
                                 class="features-manager-screen left">
                        </div>
                        <div class="features-img-crop-container ">
                            <img src="{{asset("img/collection/biz-owners/snapshots/ashojash-dashboard-1.jpg")}}" alt=""
                                 class="features-manager-screen middle">
                        </div>
                        <div class="features-img-crop-container ">
                            <img src="{{asset("img/collection/biz-owners/snapshots/ashojash-dashboard-2.jpg")}}" alt=""
                                 class="features-manager-screen right">
                        </div>
                    </div>
                    <div class="features-info-container "
                         style="background-color: #2D3339; color: #FFFFEC;padding-bottom: 30px;">
                        <h1 class="text-center p-top-20">آشوجاش، انتخاب رقیبان شما</h1>

                        <h3 class="text-center p-top-10 bottom-xs-0"> رقیبان شما از آشوجاش برای معرفی خدمات خود و پیشرفت
                            کسب و
                            کارشان استفاده می کنند.
                        </h3>
                    </div>
                    <div class="features-info-container">
                        <div class="col-xs-12 p-top-50 p-bottom-50" style="background-color: #fff">
                            <div class="col-xs-4">
                                <img src="{{asset("/img/collection/biz-owners/menu.png")}}" alt="menu-pic"
                                     class="center-img">
                            </div>
                            <div class="col-xs-8  text-center">
                                <h2>منو رستوران خود را اضافه کنید</h2>

                                <p class="text-muted features-text-describe">
                                    مهمترین چیزی که برای یک آدم گشنه مهم است منو یک رستوران و قیمت های رستوران می
                                    باشد.<br> منو خود را اضافه کنید و بازدید خود را اضافه کنید
                                </p>
                            </div>
                        </div>
                    </div>
                    {{----}}
                    <div class="features-info-container">
                        <div class="col-xs-12 p-top-50 p-bottom-50" style="background-color: #fff">
                            <div class="col-xs-8  text-center">
                                <h2>ساعات کسب کارتان را اضافه کنید</h2>

                                <p class="text-muted features-text-describe">
                                    با اضافه کردن ساعات کسب و کارتان <br>همیشه برای کاربران در دسترس باشید.

                                </p>
                            </div>
                            <div class="col-xs-4">
                                <img src="{{asset("/img/collection/biz-owners/clock.png")}}" alt="clock-pic"
                                     class="center-img">
                            </div>

                        </div>
                    </div>
                    {{----}}
                    <div class="features-info-container">
                        <div class="col-xs-12 p-top-50 p-bottom-50" style="background-color: #fff">
                            <div class="col-xs-4">
                                <img src="{{asset("/img/collection/biz-owners/map.png")}}" alt="clock-pic"
                                     class="center-img">
                            </div>

                            <div class="col-xs-8  text-center">
                                <h2>اطلاعات کسب و کار خود را به روز نگه دارید</h2>

                                <p class="text-muted features-text-describe">اطلاعاتی همچون آدرس، نقشه و شماره تماس خود
                                    را اضافه کنید<br> تا کاربران بتوانند شما را پیدا کنند.</p>
                            </div>

                        </div>
                    </div>
                    {{----}}
                    <div class="features-info-container">
                        <div class="col-xs-12 p-top-50 p-bottom-50" style="background-color: #fff">
                            <div class="col-xs-8  text-center">
                                <h2>با کاربران در ارتباط باشید</h2>

                                <p class="text-muted features-text-describe">
                                    نظرات کاربران را درباره کسب و کار خود بدانید <br>و با آن ها در ارتباط باشید.

                                </p>
                            </div>
                            <div class="col-xs-4">
                                <img src="{{asset("/img/collection/biz-owners/comment.png")}}" alt="clock-pic"
                                     class="center-img">

                            </div>

                        </div>
                    </div>
                    {{----}}
                    <div class="features-info-container ">
                        <div class="col-xs-12" style="background-color: #e0e0e0">
                            @include('pages.partials.search-venue')
                        </div>
                    </div>
                    <div class="features-info-container">
                        <div class="col-xs-12 text-center">
                            <h2>
                                ما یک استارآپ هستیم
                            </h2>

                            <p class="text-muted" style="font-size: 16px">لطفا توجه داشته باشید که به زودی امکانات بسیار
                                بیشتری نیز اضافه خواهند شد!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer.scripts')
    <script src="{{asset('js/typeahead.bundle.min.js')}}"></script>
    <script src="{{asset("js/bloodhound.min.js")}}"></script>
    <scrtip src="{{asset("js/typeahead.jquery.min.js")}}"></scrtip>
    <script src="{{asset("js/search.js")}}"></script>
@stop