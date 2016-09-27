@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-xs-12" style=" ">
            @include('admin.users.partials.thumbnail')
            <div class="col-xs-12 col-sm-6 col-md-8 white-bg shadow-1" style="border-radius: 10px">
                @include('admin.users.partials.reviews')
            </div>
        </div>
    </div>
@stop
@section('footer.scripts')
    <script src="{{asset('js/ban-user.js')}}"></script>
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
                    animate: true,
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
@stop