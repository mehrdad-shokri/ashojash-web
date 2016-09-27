@extends('users.user-base-layout')

@section('innerContent')
    @include('modals.venue-image-view')
    <div class=" rtl">
        <div class="row ">
            <div class="col-xs-12 top-xs-20 bottom-xs-20 text-center">
                <h4 class="review-heading right-xs-20">
                    عکس‌های
                    {{$user->name}}
                </h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                @include('users.partials.venue-photos')
            </div>
        </div>
    </div>
@stop
@section('footer.innerScripts')
    <script src="/js/async-loader.js"></script>
    <script>

        $(document).ready(function () {
            echo.init({
                offset: 250,
                throttle: 250,
                unload: false,
            });
        });
    </script>
    <script src="/js/follows.js"></script>
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
        })
    </script>

@stop
@section('header.innerStylesheets')
    <link rel="stylesheet" href="/css/image-gallery.css">
    <link rel="stylesheet" href="/css/image-gallery-skin.css">
@stop