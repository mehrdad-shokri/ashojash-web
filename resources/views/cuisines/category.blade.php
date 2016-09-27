@extends('layout')

@section('content')
    <div class="container ashjsh-container">
        <div class="white-bg p0 stick-to-navbar">
            @include('cuisines.partials.cuisine-hero')
            <div class="row ashjsh-row">
                <div class="col-xs-12 top-xs-40" id="venues-container">
                    @foreach($venues as $venue)
                        <div class="col-xs-12 col-sm-12 col-md-4 col-hidden-lg min-md-top-40 venue-card odd shadow-2 item">
                            <div class="thumbnail venue-image-container">
                                <div class="venue-image-div">
                                    <div id="{{$venue->slug}}" class="venue-image venue-image-card "
                                         style="background-image:url('https://ashojash.com/img/blur.jpg') "
                                         data-echo-background="{{action('PhotosController@getVenuePhoto',array($venue->slug,200))}}">
                                        <a class="image-link"
                                           href="{{action('VenuesController@show',$venue->slug)}}"></a>
                                    </div>
                                </div>
                                <div class="venue-image-content">
                                    <div class="venue-info">
                                        <div class="venue-score {{UI::ratingClass($venue->score)}}">{{$venue->score <1 ? "-" : $venue->score}}</div>
                                        <p class="venue-name">{{$venue->name}}</p>
                                        <a class="venue-neighbor">{{$venue->name}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="caption free-sans venue-caption">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="col-xs-6 col-xs-offset-6 venue-cuisines">
                                            @include('venues.partials.venue-cuisine')
                                        </div>
                                    </div>
                                </div>
                                <div class="row top-xs-5">
                                    <div class="col-xs-12">
                                        <div dir="rtl" class="col-xs-6 col-xs-offset-6">
                                            <span>قیمت: </span>
                                            @include('venues.partials.venue-cost')
                                        </div>
                                    </div>
                                </div>
                                <div class="row top-xs-5 ">
                                    <div class="col-xs-9 rtl venue-details faNum div-child-right">
                                        @if($venue->reviews->count()>0)
                                            <div class="col-md-3  col-xs-2 "><a
                                                        href="{{url('venue/'.$venue->slug.'#reviews')}}"
                                                        class="">{{$venue->reviews->count()}}مرور </a>
                                            </div>
                                        @endif
                                        @if($venue->photos->count()>0)
                                            <div class="col-md-5 col-xs-4 "><a
                                                        href="{{action('VenuesController@photos',$venue->slug)}}"
                                                        class="">{{$venue->photos->count()}} عکس</a></div>
                                        @endif
                                        @if($venue->menu)
                                            <div class="col-xs-3 "><a
                                                        href="{{action('VenuesController@menu',$venue->slug)}}"
                                                        class="parseToFarsi">منو</a></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="ltr">
            {!! $venues->render() !!}
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
    <script src="/js/jquery.infinitescroll.js"></script>
    <script>
        $('#venues-container').infinitescroll({
                    navSelector: "ul.pager",
                    // selector for the paged navigation (it will be hidden)
                    nextSelector: "ul.pager li:last-child a",
                    // selector for the NEXT link (to page 2)
                    itemSelector: "#venues-container div.venue",
                    // selector for all items you'll retrieve
                    animate: false,
                    loading: {
                        img: "/img/static/Preloader_small.gif",
                        msgText: "<p style='font-size: 16px'>در حال دریافت اطلاعات...</h5>",
                        finishedMsg: "<p style='font-size: 16px'>اطلاعات بیشتر برای نمایش وجود ندارد.</p>"
                    }
                }, function () {
//                    callback function
                }
        );
    </script>
@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="/css/cuisine.css">
    <link rel="stylesheet" href="/css/home.css">
@stop