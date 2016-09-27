@extends('layout')

@section('content')
    @include('modals.venue-image-view')
    <div class="container ashjsh-container ">
        <div class="white-bg p0 stick-to-navbar">
            <div class="row ashjsh-row p-bottom-20">
                <div class="col-xs-12">
                    <div class="top-xs-20">
                        <div class="col-xs-12">
                            <div class="col-xs-4 top-xs-20 ">
                                <a href="{{action("VenuesController@show",$venue->slug)}}">
                                    <div class="item-topic left">
                                        مشاهده صفحه اصلی کسب و کار
                                        <i class="fa fa-arrow-left"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <h2 class="item-topic">تصاویر
                            </h2>
                        </div>
                        <div class="col-xs-12 top-xs-40">
                            @include('venues.partials.venue-photos-all')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
        </div>
    </div>
    </div>
@stop
@section('footer.scripts')
    <script src="/js/async-loader.js"></script>
    <script>
        $(document).ready(function () {
            echo.init({
                offset: 100,
                throttle: 250,
                unload: false,
            });
        });
    </script>
    <script src="/js/async-loader.js"></script>
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
@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="/css/image-gallery.css">
    <link rel="stylesheet" href="/css/image-gallery-skin.css">
@stop