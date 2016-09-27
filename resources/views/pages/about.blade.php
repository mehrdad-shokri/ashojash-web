@extends('layout')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg p0 stick-to-navbar">
            @include('pages.partials.about-hero')
            <div class="row ashjsh-row">
                <div class="col-xs-12 text-center ">
                    <h2>و این را توسط موارد زیر انجام می دهیم.</h2>
                    <ul class="we-do top-xs-30">
                        <li><b>راهنمایی مردم برای پیدا کردن بهترین مکان ها</b><br>

                            <p>
                                مرورها و امتیاز های آشوجاش بر اساس نظرات کاربران عادی، مثل شما، است که از Ashojash.com
                                بازدید می کنند تا تجربیاتشان را درباره جاهای مختلف بیان کنند.
                            </p>
                        </li>
                        <li><b>ساخت تجربه های جدید سرو غذا</b><br>

                            <p>

                                ما با امکاناتی مثل نوشتن مرور برای رستوران ها، اضافه کردن عکس، فالو کردن دوستانتان ،
                                تجربه
                                جدید و دلخواه تری در سرو غذا برایتان ایجاد می کنیم.

                            </p>
                        </li>
                        <li><b>قادر ساختن رستوران ها برای ساختن تجربه ای شگفت انگیز</b><br>

                            <p>

                                با ابزارهای مدریتی مختص صاحبان کسب و کار، ما صاحبان کسب و کار را قادر می کنیم تا زمان
                                بیشتری
                                را روی خود غذا تمرکز کنند.<br>
                                که مستقیما به بهبود تجربه غذا منجر می شود.

                            </p></li>
                    </ul>
                    <a href="{{action("PagesController@policies")}}" class="ghost-btn top-xs-40" style="width: 100px;">
                        بیشتر بدانید
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer.scripts')
    <script src="/js/async-loader.js"></script>
    <script>
        $(document).ready(function () {
            echo.init({
                offset: 600,
                throttle: 250,
                unload: false,
            });
        });
    </script>
@stop