$(document).ready(function () {
    var priceHolder = 0;
    var qualityHolder = 0;
    var decorHolder = 0;

    $(function () {
        $("#cost-rating").barrating({
            theme: 'bars-1to10',
            showSelectedRating: true,
            fastClicks: true,
            wrapperClass: "br-wrapper",
            onSelect: function (value, text) {
                priceHolder = value;
            }
        });
        $("#quality-rating").barrating({
            theme: 'bars-1to10',
            showSelectedRating: true,
            fastClicks: true,
            wrapperClass: "br-wrapper",
            onSelect: function (value, text) {
                qualityHolder = value;
            }
        });
        $("#decor-rating").barrating({
            theme: 'bars-1to10',
            showSelectedRating: true,
            fastClicks: true,
            wrapperClass: "br-wrapper",
            onSelect: function (value, text) {
                decorHolder = value;
            }
        });
        $(".br-current-rating").css("width", "150px").css("color", "#9E9E9E").css("font-size", "15px").css("font-weight", "bold");
    });


    $("#js-trigger-review").on("click", function () {
        $(this).removeClass("hand");
        $("#review-hint").addClass("hidden");
        $("#review-section").fadeIn().removeClass("hidden");
        return true;
        //bring review section
    });
    $("#upload-photo-section").click(function () {
        $(this).fadeOut().addClass("hidden");
        $("#upload-photo-method").fadeIn().removeClass("hidden");
        return false;
    });

    $("#uploadInstagram").on("click", function () {
        //open instagram
        return false;
    });

    $("#cancel-review").on("click", function (e) {
        returnDefaultState();
        return false;
    });
    $("#publish-btn").on("click", function () {
        var reviewText = $("#review-text");
        var length = reviewText.val().length;
        if (length < 70) {
            swal({
                title: "توجه",
                text: "مرور شما حداقل باید 70 کاراکتر باشد",
                type: "info",
                confirmButtonText: 'باشه',
                showConfirmButton: true
            });
        }
        else if (priceHolder == 0 || qualityHolder == 0 || decorHolder == 0)
            swal({
                title: "توجه",
                text: "فیلدهای ارزیابی الزامی است",
                type: "info",
                confirmButtonText: 'باشه',
                showConfirmButton: true
            });
        else
            sendPublishReviewRequest();
        return false;
    });
    function sendPublishReviewRequest() {
        var venueSlug = $("#venueSlug").val();
        var review_text = $("#review-text").val();
        var objectData = {
            "review-text": review_text,
            "decor": decorHolder,
            "cost": priceHolder,
            "quality": qualityHolder,
            "venueSlug": venueSlug
        };
        var objectDataString = JSON.stringify(objectData);
        $.ajax("/user/review/add", {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {

            },
            dataType: "json",
            data: {
                data: objectDataString
            },
            success: function (data) {
                swal({
                    title: "پایان",
                    text: "مرور شما با موفقیت ثبت شد",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
                returnDefaultState();
            },
            error: function (e) {
                //show error
                console.log(e.status);
                if (e.status == 429)
                    swal({
                        title: "خطا",
                        text: "ببخشید، برای هر مکان در طول هفته،‌ تنها یک مرور می توانید بنویسید!",
                        type: "error",
                        confirmButtonText: 'باشه',
                        showConfirmButton: true
                    });
                else
                    swal({
                        title: "خطا",
                        text: "خطایی در ثبت مرور رخ داد دوباره امتحان کنید",
                        type: "error",
                        confirmButtonText: 'باشه',
                        showConfirmButton: true
                    });
                returnDefaultState();
            },
            type: "POST"
        });
    }

    function returnDefaultState() {
        $("#js-trigger-review").addClass("hand");
        $("#review-section").fadeOut();
        $("#review-section").addClass("hidden");
        $("#review-hint").removeClass("hidden");
    }

    /*function barRating(id, valueHolder) {
     $("#" + id).barrating({
     theme: 'bars-1to10',
     showSelectedRating: true,
     fastClicks: true,
     initialRating: 3,
     wrapperClass: "br-wrapper",
     onSelect: function (value, text) {
     priceHolder = value;
     }
     });
     }*/
});
