@extends('layout-relative-navbar')

@section('content')
    <div class="container ">
        <div class="white-bg stick-to-navbar ">
            <div class="row p-right-20 p-left-20">
                <div class="first-page-hero-container">
                    <div class="col-xs-6">
                        <p class="hero-desc">
                            با آشوجاش بهترین ذائقه های اطرافتان را پیدا کنید، برای رستوران های مورد علاقه خود مرور
                            بنویسید، دوستان جدید پیدا کنید و بسیاری امکانات دیگر.
                        </p>
                    </div>
                    <div class="col-xs-6">
                        <h3 class="hero-text">
                            بهترین ذائقه های اطرافتان را با آشوجاش پیدا کنید

                        </h3>
                    </div>

                </div>
                @foreach($cities->chunk(2) as $key=>$cityChunk)
                    <div class="row cities {{($key==0)?"p-top-15":""}}">
                        @foreach($cityChunk as $city)
                            <div class="col-xs-12 col-md-6 city-block">
                                <a href="{{action('CitiesController@setCity',$city->slug)}}">
                                    <img src="{{action('PhotosController@getCityPhoto',$city->slug)}}" alt="">
                                    <span class="city-label">{{$city->name}}</span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <p class="text-muted" style="font-size: 16px">
                    و به زودی تمام ایران!
                </p>
            </div>
        </div>
    </div>

@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="/css/home.css">
@stop