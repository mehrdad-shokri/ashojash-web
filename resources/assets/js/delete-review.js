var deleteReviewBtn = $(".delete-review-btn");
deleteReviewBtn.on("click", function () {
    var review = $(this).closest(".review");
    var reviewId = review.attr("data-review-id");
    swal({
        title: "حذف مرور؟",
        text: "مرور شما قابل بازگردانی نخواهد بود",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        showLoaderOnConfirm: true,
        confirmButtonText: "بله، پاک کن",
        cancelButtonText: "بی خیال",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true,
    }, function (isConfirm) {
        if (isConfirm) {

            sendDeleteAjax(parseInt(reviewId), review);
        }
    });
    return;

});
function hideReview(review) {
    setTimeout(function () {
        review.slideUp();
    }, 1720);
}
function sendDeleteAjax(reviewId, review) {
    $.ajax("/user/review/delete/" + reviewId, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        },
        success: function (data) {
            swal({
                title: "پایان",
                text: "مرور شما با موفقیت حذف شد",
                type: "success",
                timer: 1500,
                showConfirmButton: false
            });
            hideReview(review);
        },
        error: function () {
            swal({
                title: "خطا",
                text: "خطایی در حذف مرور شما رخ داد، دوباره تلاش کنید",
                type: "error",
                confirmButtonText: 'باشه',
                showConfirmButton: true
            });
        },
        type: "DELETE"
    });
}