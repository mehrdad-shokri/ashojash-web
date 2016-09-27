@extends('layout')

@section('content')
    @include('modals.venue-image-view')
    @include('modals.upload-venue-photos')
    <div class="container ashjsh-container ">
        <div class="white-bg p0 stick-to-navbar">
            @include('venues.partials.venue-hero')
            <div class="row ashjsh-row">
                <div class="col-xs-12 p-max-md-right-0 p-sm-only-left-0">
                    <div class="col-md-4 col-xs-12 item-info-section right item-thumbnail ">
                        @include('venues.partials.venue-sidebar')
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="col-xs-12">
                            <div class="row">
                                <h2 class="item-topic">
                                    <a href="{{action("VenuesController@menu",$venue->slug)}}">
                                        منو
                                    </a>
                                </h2>

                                <div class="row">
                                    @include('venues.partials.venue-menu')
                                </div>
                            </div>
                        </div>
                        <div class="row top-xs-40">
                            <div class="col-md-12">
                                <h2 class="item-topic "><a
                                            href="{{action("VenuesController@photos",$venue->slug)}}">تصاویر</a>
                                </h2>

                                <div class="row top-xs-20">
                                    @include('venues.partials.venue-photos')
                                </div>
                            </div>
                        </div>
                        <div class="row top-xs-20">
                            <div class="col-md-12 top-xs-40">
                                <h2 class="item-topic">
                                    نظری بنویسید
                                </h2>
                            </div>
                            <div class=" top-xs-20">
                                @if($currentUser)
                                    @include('venues.partials.add-review')
                                @else
                                    @include('venues.partials.login-form')
                                @endif
                            </div>
                        </div>
                        <div class="top-xs-30" id="reviews">
                            <div class="col-md-12">
                                <h2 class="item-topic"><a href="#reviews" style="text-decoration: none">نظرات</a>
                                </h2>
                            </div>
                            <div class="row">
                                @include('venues.partials.venue-reviews',$reviews)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>
    </div>
@stop
@section('footer.scripts')

    <script>
        $("#res-timings-toggle").on("click", function (e) {
            e.preventDefault();
            var resTiming = $(this);
            /* $("#timings-all").toggleClass('collapse');
             $("#timings-all").fadeIn();*/
            if ($("#timings-all").hasClass("hidden")) {
                resTiming.text('(کمتر ببینید -)')
                $('#timings-all').css('visibility', 'visible').hide().toggleClass('hidden').slideDown();
            }
            else {
                resTiming.text('(بیشتر ببینید +)')

                $('#timings-all').css('visibility', 'visible').slideUp(function () {
                    $(this).hide().toggleClass('hidden');

                });
            }
        });
    </script>
    <script>
        /* var document = $(document);
         if ($(window).width() > 974) {
         var leftHeight = $('.left').height();
         var rightHeight = $(".right").height();
         var maxHeight = leftHeight > rightHeight ? leftHeight : rightHeight;
         $(".right").height(maxHeight);
         $(".left").height(maxHeight);
         }

         $(window).resize(function () {
         var leftHeight = $('.left').height();
         var rightHeight = $(".right").height();
         var maxHeight = leftHeight > rightHeight ? leftHeight : rightHeight;
         var width = $(this).width();
         if (width <= 974) {
         $(".right").css("height", "");
         $(".left").css("height", "");
         }
         else {
         $(".right").css("height", maxHeight);
         $(".left").css("height", maxHeight);
         }
         });*/
    </script>

    <script src="/js/review.js"></script>
    <script src="/js/async-loader.js"></script>
    @include('layouts.partials.scripts.venue-dropzone')
    <script>
        $(document).ready(function () {
            echo.init({
                offset: 100,
                throttle: 250,
                unload: false,
            });
        });
    </script>
    <script src="/js/image-gallery.min.js"></script>
    <script src="/js/image-gallery-skin.min.js"></script>
    <script>
        var pswpElement = document.querySelectorAll('.pswp')[0];
        $(".galleryGroup .galleryPopup").on("click", function () {
            var items = [
                    @foreach($photos as $photo){
                    src: "{{action("PhotosController@getPhotoByFilename",array($photo->filename)) }}",
                    w: "{{ UI::getPhotoWidth($photo->id)}}",
                    h: "{{UI::getPhotoHeight($photo->id)}}",
                    title: "<b><h1>hello world</b></h1>",
                },
                @endforeach

            ];
            var options = {
                index: $(".galleryPopup").index($(this)), // start at first slide
                bgOpacity: .9,
                closeOnScroll: true,
                errorMsg: "مشکل در بارگذاری تصویر",
                shareEl: false,
                preload: [1, 3],
                fullscreenEl: true,
                captionEl: false,
                showHideOpacity: true,
                tapToToggleControls: true,
                getThumbBoundsFn: function (index) {
                    var thumbnail = document.querySelectorAll('.galleryPopup')[index];
                    var pageYScroll = window.pageYOffset || document.documentElement.scrollTop;
                    var rect = thumbnail.getBoundingClientRect();
                    return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};
                },
            };
            var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
            return false;
        })
    </script>

    <script src="/js/jquery.barrating.min.js"></script>
    <script src="/js/jquery.infinitescroll.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
    <script>


        $('#reviews-container').infinitescroll({
                    navSelector: "ul.pager",
                    // selector for the paged navigation (it will be hidden)
                    nextSelector: "ul.pager li:last-child a",
                    // selector for the NEXT link (to page 2)
                    itemSelector: "#reviews-container div.review",
                    // selector for all items you'll retrieve
                    animate: false,
                    loading: {
                        img: "/img/static/Preloader_small.gif",
                        msgText: "<p style='font-size: 16px'>در حال دریافت اطلاعات...</h5>",
                        finishedMsg: "<p style='font-size: 16px'>اطلاعات بیشتر برای نمایش وجود ندارد.</p>"
                    }
                }, function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }
        );
    </script>
    {{-- google map --}}
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
        var lat = "{{$venue->location->lat}}";
        var lng = "{{$venue->location->lng}}"
        var venueCenter = new google.maps.LatLng(lat, lng);

        function initialize() {
            var mapProp = {
                center: venueCenter,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true
            };

            var map = new google.maps.Map(document.getElementById("g-map"), mapProp);

            var marker = new google.maps.Marker({
                position: venueCenter,
            });

            marker.setMap(map);

            var infowindow = new google.maps.InfoWindow({
                content: "<b>{{$venue->name}}</b>" + "<small class='dis-block max-w-110'>{{$venue->location->address}}</small>"
            });

            infowindow.open(map, marker);
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

    {{UI::setTimeDefault()}}
@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="{{asset("css/venue-show.css")}}">
    <link rel="stylesheet" href="{{asset("css/image-gallery.css")}}">
    <link rel="stylesheet" href="{{asset("css/image-gallery-skin.css")}}">
    <link rel="stylesheet" href="{{asset("css/bars-1to10.css")}}">
    <link rel="stylesheet" href="{{asset("css/fontawesome-stars.css")}}">
    <link rel="stylesheet" href="{{asset("css/bars-horizontal.css")}}">
@stop