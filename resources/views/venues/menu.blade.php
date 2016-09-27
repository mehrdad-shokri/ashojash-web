@extends('layout')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg p0 stick-to-navbar">
            <div class="row ashjsh-row">
                <div class="col-xs-12">
                    <div class="col-xs-4 top-xs-20 ">
                        <a href="{{action("VenuesController@show",$venue->slug)}}">
                            <div class="left" style="color: #333">
                                مشاهده صفحه اصلی کسب و کار
                                <i class="fa fa-arrow-left"></i>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 rtl">
                        <h2 class="item-topic ">
                            منو
                        </h2>
                    </div>
                    <div class="top-xs-40">
                        @include('venues.partials.venue-menu-full')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop