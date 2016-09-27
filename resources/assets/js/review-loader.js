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