@extends('layout-basic')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg stick-to-navbar">
            <div class="row">
                <div class="col-xs-12 col-md-6 auth__auth-frame right">
                    <div class=" pr-0">
                        <h4 class=" text-center login-header">
                            ورود آشوجاش
                        </h4>
                        <h5 class="text-center" style="font-size: 18px;">بهترین طعم های اطرافتان را پیدا کنید</h5>

                    </div>
                    <div class=" top-xs-40 right-xs-20 float-children-right">

                        {{--<div class="col-xs-10 top-xs-20">
                            <a class="btn btn-block btn-social btn-instagram ashjsh-btn-social"
                               href="{{action("InstagramOauthController@redirectProvider")}}">
                                <div class="right text">ورود با اینستاگرم</div>
                                <div class="fa fa-instagram icon"></div>
                            </a>
                        </div>--}}
                        <div class="col-xs-10 top-xs-20">
                            <a class="btn btn-block btn-social btn-google ashjsh-btn-social"
                               href="{{action("GoogleOauthController@redirectProvider")}}">
                                <div class="right text">ورود با گوگل</div>
                                <div class="fa fa-google-plus icon"></div>
                            </a>
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
                        <div class="col-xs-10 top-xs-40">
                            <h2 class="br-line"><span>یا</span></h2>
                        </div>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
                            <!--- Fullname Field --->
                            <!--- Username Field --->
                        {{--  <div class="form-group col-xs-10">
                              {!! Form::label('username', 'نام کاربری:') !!}
                              {!! Form::text('username', null, ['class' => 'form-control']) !!}
                          </div>--}}

                        <!--- Email Field --->
                            <div class="form-group col-xs-10">
                                {!! Form::label('login', 'ایمیل یا نام کاربری:') !!}
                                {!! Form::text('login', null, ['class' => 'form-control ltr']) !!}
                            </div>
                            <!--- Password Field --->
                            <div class="form-group col-xs-10 bottom-xs-5">
                                {!! Form::label('password', 'پسورد:') !!}
                                {!! Form::password('password', ['class' => 'form-control ltr']) !!}
                            </div>
                            <div class="form-group col-xs-10">
                                <input type="checkbox" name="remember">
                                مرا به خاطر بسپار
                            </div>
                            <div class="col-xs-10">
                            @include('layouts.partials.errors')

                            <!--- Sign up Field --->
                                <div id="flash_placeholder"></div>
                            </div>

                            <div class="form-group col-xs-10">
                                {!! Form::submit('ورود', ['class' => 'btn btn-primary btn-grey']) !!}
                            </div>
                            <div class="col-xs-10">
                                <a href="/password/reset">
                                    رمز عبورتان را فراموش کرده اید؟
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 auth__bundle-frame top-only-xs-20">
                    <h4 class="login-header text-center">
                        حساب کاربری ندارید؟
                    </h4>
                    <h5 class="text-center" style="font-size: 18px">
                        مشکلی نیست، هنوز هم دوستتان داریم.
                    </h5>
                    <a href="/register" class="hero-register">
                        ثبت نام
                    </a>

                    <p class="top-xs-20 text-center" style="font-size: 18px;
line-height: 35px;">
                        آشوجاش راهی ساده و لذت بخش برای پیدا کردن، مرور و صحبت کردن درباره این که
                        چه چیزهایی عالیست و چه چیزهایی آنقدرها که شاید، نیست. درباره این است که مردم
                        واقعی افکار شخصی و صادقانه خود را از رستوران ها و کافه ها گرفته تا کافه قنادی ها بیان می
                        کنند.
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="/css/social-btn.css">

@stop