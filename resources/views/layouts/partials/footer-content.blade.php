<div class="free-sans-font-only">
    <div class="col-xs-2">
        <h3 class="">آشوجاش</h3>
        <ul class="col-xs-12">
            <li><a href="{{action("PagesController@about")}}">درباره</a></li>
            <li><a href="#">بلاگ</a></li>
            <li><a href="{{action("PagesController@contact")}}">تماس با ما</a></li>
        </ul>
    </div>
    <div class="col-xs-2">
        <h3>کسب و کار</h3>
        <ul>
            <li><a href="{{action("PagesController@addPlace")}}">اضافه کردن رستوان</a></li>
            <li><a href="{{action("PagesController@businessOwners")}}">صاحبان کسب و کار</a></li>
        </ul>
    </div>
    <div class="col-xs-2">
        <h3>
            سیاست ها
        </h3>
        <ul>
            {{-- <li><a href="#">حریم خصوصی</a></li>
             <li><a href="#">شرایط استفاده</a></li>--}}
            <li><a href="{{action("PagesController@policies")}}"> راهنمایی ها و سیاست ها </a></li>
            <li><a href="{{action("PagesController@cookiePolicy")}}">کوکی</a></li>
        </ul>
    </div>
    <div class="col-xs-2">
        <h3>دیگر</h3>
        <ul>
            <li>
                @if(!Cookie::get("ashojash_feedback"))<a class="toggle-feedback-modal" id="footer-feedback-link"
                                                         href="#">
                    بازخورد
                </a>
                @endif
            </li>
            <li><a href="{{action("PagesController@contact")}}">
                    تماس با ما
                </a></li>
        </ul>
    </div>
    <div class="col-xs-4">
        <h3 id="ashojash" style="margin-bottom: 25px;">
            آشوجاش
        </h3>
        <ul>
            <li style="color: #555;direction: rtl;font-size: 15px;" class="free-sans">
                آشوجاش مرجع نهایی شما برای هر نوع غذای بیرون است. رستوران یا ذائقه مورد علاقه تان را جست و جو کنید و
                راجع به شان اطلاعات کسب کنید.رستوران هایی که در آن جا
                حضور داشتید را نقد کنید و دوستان جدید پیدا کنید.
            </li>
            <li>
                <ul class="footer-social-list col-xs-12 top-xs-10 bottom-xs-20">
                    <li class="col-md-2 col-md-offset-2 col-sm-3 col-xs-5 p-10"><a
                                href="{{url("https://www.facebook.com/ashojash")}}" target="_blank"><span
                                    class="footer-social facebook-footer fa fa-facebook"></span></a></li>
                    <li class="col-md-2 col-sm-3 col-xs-5 p-10 "><a href="{{url("https://twitter.com/ashojash")}}"
                                                                    target="_blank"><span
                                    class="footer-social twitter-footer fa fa-twitter"></span></a></li>
                    <li class="col-md-2 col-sm-3 col-xs-5 p-10"><a
                                href="{{url("https://instagram.com/ashojash")}}" target="_blank"><span
                                    class="footer-social instagram-footer fa fa-instagram"></span></a>
                    </li>
                    <li class="col-md-2 col-sm-3 col-xs-5 p-10"><a href="{{url("http://telegram.me/ashojash")}}"
                                                                   target="_blank">
                            <span class="footer-social telegram-footer fa fa-paper-plane"></span>
                        </a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>