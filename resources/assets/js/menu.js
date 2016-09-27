
$(document).ready(function () {
    var priceValContainer = $('#price');
    var priceValueHint = $('#priceHint');
    var priceError = $('#priceError');
    priceValContainer.keyup(function () {
        var price = priceValContainer.val();
        if (price.length == 0) {
            priceValueHint.addClass('hidden');
            priceError.addClass('hidden');
        }
        else if (price.match(/^[0-9]*$/)) {
            priceValueHint.removeClass('hidden');
            priceError.addClass('hidden');
            var priceHint=price.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
            priceValueHint.text("قیمت: " + priceHint + "تومان ");
            priceValueHint.persiaNumber();
        }
        else {
            priceValueHint.addClass('hidden');
            priceError.removeClass('hidden');
        }
    });
});

$(document).ready(function ($) {
    $(".clickable-row").click(function () {
        window.document.location = $(this).data("href");
    });
    $(".clickable-row").hover(function () {
        $(this).toggleClass("active");
        $(this).css('cursor', 'pointer');
        $(".clickable-row .delete-btn").toggleClass("hidden");
    });
});