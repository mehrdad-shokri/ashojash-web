@extends('layout-basic')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg p0 stick-to-navbar">
            <div class="" style="">
                <div class="col-xs-12" style="background-color: #272D45;color: #fff">
                    <div class="col-xs-12 col-sm-8 right">
                        <div class="row">
                            <div class="col-xs-12"><h1><strong>{{$venue->name}}</strong>، پیدایتان کردیم!</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 p-top-30"><h4 style="font-size: 25px;">
                                    تنها یک قدم تا گرفتن اختیار کسب و کارتان فاصله دارید
                                </h4></div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-4" style="font-size: 17px;">
                        <div class="item-claim-hero reviews col-xs-12">
                            <div class="hidden-xs col-sm-4 ">
                                <i class="icon ion-quote claim-hero-icon"></i>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <div class="row claim-hero-title">
                                    مرور
                                </div>
                                <div class="row claim-hero-info-content">
                                    {{$venue->reviews()->count()}}
                                </div>
                            </div>
                        </div>
                        <div class="item-claim-hero score col-xs-12">
                            <div class="hidden-xs col-sm-4 score">
                                <i class="icon ion-heart claim-hero-icon"></i>
                            </div>
                            <div class="col-sm-8 col-xs-12 ">
                                <div class="row claim-hero-title"> امتیاز
                                </div>
                                <div class="row claim-hero-info-content">
                                    {{$venue->score}}
                                </div>
                            </div>
                        </div>
                        <div class="item-claim-hero cost col-xs-12">
                            <div class="col-sm-4 hidden-xs">
                                <i class="icon ion-social-usd claim-hero-icon"></i>
                            </div>
                            <div class="col-xs-12 col-sm-8 ">
                                <div class="row claim-hero-title"> قیمت
                                </div>
                                <div class="row claim-hero-info-content">
                                    {{$venue->cost}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 white-bg">
                    <h1 class="faNum">
                        می‌توانید با پرداخت هزینه 168000 تومان اختیار کسب و کارتان را در دست بگیرید.
                    </h1>
                    <h4>این هزینه به صورت ماهیانه می‌باشد
                    </h4>
                    <a href="{{action("PaymentsController@initialize",['venueSlug'=>$venue->slug])}}">پرداخت هزینه عضیویت از طریق کارت های عضو شتاب</a>

                    <h3 class="text-center top-xs-60">
                        برای آشنایی بیشتر با امکانات بخش صاحبان کسب‌وکار
                        <a href="{{action("PagesController@businessOwners")}}">
                            اینجا
                        </a>
                        کلیک کنید.
                    </h3>
                </div>
            </div>
        </div>
    </div>
@stop