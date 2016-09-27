@extends('layout')

@section('content')
    <div class="container ashjsh-container">
        <div class="white-bg p0 stick-to-navbar">
            @include('cuisines.partials.cuisine-all-hero')
            <div class="row ashjsh-row">
                <div class="col-xs-12 top-xs-40" id="venues-container">
                    @foreach($cuisines as $cuisine)
                        <div class="col-xs-12 col-sm-12 col-md-4 col-hidden-lg min-md-top-40 item-card odd shadow-2 item">
                            <a class="" style="display: block"
                               href="{{action('CitiesController@allVenuesCuisine',array($currentCity->slug,$cuisine->slug))}}">
                                <div class="thumbnail item-image-container">
                                    <div class="item-image-div">
                                        <div id="{{$cuisine->slug}}" class="item-image item-image-card "
                                             style="background-image:url('https://ashojash.com/img/blur.jpg') "
                                             data-echo-background="{{action('PhotosController@getCuisinePhoto',array($cuisine->slug,300))}}">
                                        </div>
                                    </div>

                                </div>
                            </a>

                            <div class="caption free-sans item-caption">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="col-xs-12 item-cuisines text-center" style="font-size: 18px">
                                            {{$cuisine->name}}
                                        </div>
                                        <div class="col-xs-12  top-xs-20 item-cuisines faNum">

                                            {{$cuisine->venues->count()}}
                                            مکان
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
        <div class="ltr">
            {!! $cuisines->render() !!}
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