@extends('layout-basic')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg stick-to-navbar">
            <div class="row ">
                <div class="col-xs-12 col-md-6 rtl float-children-right auth__auth-frame">
                    <div class="col-xs-12">
                        <h4 class=" text-center" style="
    color: #B30C0C;
    font-size: 23px;
    font-weight: bold;
    line-height: 36px;

">
                            ثبت نام آشوجاش
                        </h4>
                        <h5 class="text-center" style="font-size: 18px;
">بهترین طعم های اطرافتان را پیدا کنید</h5>
                    </div>
                    {{--<div class="col-xs-10 top-xs-20">
                        <a class="btn btn-block btn-social btn-instagram ashjsh-btn-social"
                           href="{{action("InstagramOauthController@redirectProvider")}}">
                            <div class="right text">ورود با اینستاگرم</div>
                            <div class="fa fa-instagram icon"></div>
                        </a>
                    </div>--}}
                    <div class="col-xs-10 col-xs-offset-1 top-xs-40 left">
                        <a class="btn btn-block btn-social btn-google ashjsh-btn-social"
                           href="{{action("GoogleOauthController@redirectProvider")}}">
                            <div class="right text">
                                ورود با گوگل
                            </div>
                            <div class="fa fa-google-plus icon"></div>
                        </a>

                        <p class="text-muted top-xs-10"> توصیه شده و هیچگاه بدون اجازه شما مخاطبانتان را اضافه نمی
                            کنیم. </p>

                    </div>
                    {{--<div class="col-xs-10 top-xs-10">
                        <a class="btn btn-block btn-social btn-twitter  ashjsh-btn-social" href="{{action("TwitterOauthController@redirectProvider")}}">
                            <div class="right text">ورود با توئیتر</div>
                            <div class="fa fa-twitter icon"></div>
                        </a>
                    </div>--}}

                    {{--
                    <div class="col-xs-10 top-xs-20">
                        <a class="btn btn-block btn-social btn-facebook ashjsh-btn-social">
                            <div class="right text">ورود با فیسبوک</div>
                            <div class="fa fa-facebook-f icon"></div>
                        </a>
                    </div>--}}
                    <div class="col-xs-10 col-xs-offset-1 left top-xs-40">
                        <h2 class="br-line"><span>یا</span></h2>
                    </div>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}

                    <!--- Fullname Field --->
                        <div class="form-group col-xs-10 top-xs-40">
                            {!! Form::label('name', 'نام کامل شما:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>"نامتان را به زبان فارسی و با خط فارسی بنویسید."]) !!}
                        </div>
                        <!--- Username Field --->
                        <div class="form-group col-xs-10">
                            {!! Form::label('username', 'نام کاربری:') !!}
                            {!! Form::text('username', null, ['class' => 'form-control input-rtl','placeholder'=>'تنها حروف،اعداد و خط تیره']) !!}
                        </div>

                        <!--- Email Field --->
                        <div class="form-group col-xs-10">
                            {!! Form::label('email', 'ایمیل:') !!}
                            {!! Form::email('email', null, ['class' => 'form-control ltr']) !!}
                        </div>
                        <!--- Password Field --->
                        <div class="form-group col-xs-10">
                            {!! Form::label('password', 'پسورد:') !!}
                            {!! Form::password('password', ['class' => 'form-control ltr']) !!}
                        </div>
                        <div class="col-xs-10">
                        @include('layouts.partials.errors')

                        <!--- Sign up Field --->
                            <div id="flash_placeholder"></div>
                        </div>
                        <div class="form-group col-xs-10">
                            {!! Form::submit('ثبت نام', ['class' => 'btn btn-primary btn-grey']) !!}
                        </div>
                        <div class="col-xs-10">
                            <span class="text-muted">حساب کاربری دارید؟&nbsp;&nbsp;</span><a
                                    href="/login">وارد شوید</a>
                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-md-6 auth__bundle-frame  top-only-xs-20">
                    <h4 class="login-header text-center">
                        آشوجاش
                    </h4>
                    <h5 class="text-center" style="font-size: 18px">
                        شروع چشیدن تجربه‌های جدیدتان
                    </h5>

                    <p class="text-center top-xs-40" style="line-height: 34px;font-size: 18px">
                        آشوجاش راهی ساده و لذت بخش برای پیدا کردن، مرور و صحبت کردن درباره این که چه چیزهایی عالیست و چه
                        چیزهایی آنقدرها که شاید، نیست. درباره این است که مردم واقعی افکار شخصی و صادقانه خود را از
                        رستوران ها و کافه ها گرفته تا کافه قنادی ها بیان می کنند.
                        </h4>

                </div>
            </div>
        </div>
    </div>
@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="/css/social-btn.css">
@stop
@section('footer.scripts')
    <script src="{{asset("js/register.js")}}"></script>
@stop