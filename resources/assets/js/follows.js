$(document).ready(function () {
    styleBtnPadding();
    $(".user-follow-btn").click(function () {
        var clickedItem = $(this);
        var isFollowing = $(this).attr('data-isFollowing') === "1";
        var clickedSpan = $(this);
        var iElement = clickedSpan.find("i");
        var uId = $(this).attr('data-uId');
        if (isFollowing) {
            sendUnfollowRequest(uId, iElement, clickedItem);
        }
        else {
            sendFollowRequest(uId, iElement, clickedItem);
        }
    });

    function sendFollowRequest(uId, iElement, clickedItem) {
        $.ajax('/user/follow/' + uId, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                setPending(clickedItem);
            },
            data: function () {

            },
            success: function (data) {
                iElement.removeClass("ion-ios-personadd-outline");
                iElement.addClass("ion-checkmark-round");
                reverseIsFollowing(clickedItem);
                styleBtnPadding();
            },
            error: function () {
                styleBtnPadding();
            },
            type: "POST"
        });
    }

    function sendUnfollowRequest(uId, iElement, clickedItem) {
        $.ajax('/user/unfollow/' + uId, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function () {

            },
            beforeSend: function () {
                setPending(clickedItem);
            },
            success: function (data) {
                iElement.removeClass("ion-checkmark-round");
                iElement.addClass("ion-ios-personadd-outline");
                reverseIsFollowing(clickedItem);
                styleBtnPadding();
            },
            error: function () {
                styleBtnPadding();
            },
            type: "DELETE"

        });
    }

    function styleBtnPadding() {
        $(".user-follow-btn:has('i.ion-ios-personadd-outline')").css('padding', '13px 4px 0px');
        $(".user-follow-btn:has('i.ion-checkmark-round')").css('padding', '13px 2px 1px');
        $(".user-follow-btn").css('border', '1px solid #A7A5A5');

    }

    function setPending(clickedItem) {
        clickedItem.css('border', '1px solid #bc3135');

    }

    function reverseIsFollowing(clickedItem) {
        var isFollowing = clickedItem.attr('data-isFollowing') === "1";
        clickedItem.attr('data-isFollowing', !isFollowing ? "1" : "0");
    }
});

$(document).ready(function () {
    styleBtn($(".social-primary-btn"));
    $(".social-primary-btn").click(function () {
        var clickedItem = $(this);
        var isFollowing = $(this).attr('data-isFollowing') === "1";
        var uId = $(this).attr('data-uId');
        if (isFollowing) {
            sendUnfollowRequest(uId, clickedItem);
        }
        else {
            sendFollowRequest(uId, clickedItem);
        }
    });

    function sendFollowRequest(uId, clickedItem) {
        $.ajax('/user/follow/' + uId, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                setPending(clickedItem);
            },
            data: function () {

            },
            success: function (data) {
                reverseIsFollowing(clickedItem);
                styleBtn(clickedItem);
            },
            error: function () {
                reversePending(clickedItem);
            },
            type: "POST"
        });
    }


    function sendUnfollowRequest(uId, clickedItem) {
        $.ajax('/user/unfollow/' + uId, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: function () {

            },
            beforeSend: function () {
                setPending(clickedItem);
            },
            success: function (data) {
                reverseIsFollowing(clickedItem);
                styleBtn(clickedItem);

            },
            error: function () {
                reversePending(clickedItem);
            },
            type: "DELETE"

        });
    }


    function setPending(clickedItem) {
        if (clickedItem.attr('data-isFollowing') === "1") {
            clickedItem.text('فالو');
        }
        else {
            //clickedItem.css('background-color', '#52E71C');
            clickedItem.text('در حال دنبال کردن');
        }
        /*background-color: green;*/
    }

    function reversePending(clickedItem) {
        if (clickedItem.attr('data-isFollowing') === "0") {
            clickedItem.text('فالو');
        }
        else {
            //clickedItem.css('background-color', '#52E71C');
            clickedItem.text('در حال دنبال کردن');
        }
    }

    function styleBtn(clickedItem) {
        if (clickedItem.attr('data-isFollowing') === "0") {
            clickedItem.removeClass("unfollow-btn")
            clickedItem.addClass("follow-btn");
            clickedItem.text('فالو');
        }
        else {
            clickedItem.removeClass("follow-btn");
            clickedItem.addClass("unfollow-btn");
            clickedItem.text('در حال دنبال کردن');
        }
    }

    function reverseIsFollowing(clickedItem) {
        var isFollowing = clickedItem.attr('data-isFollowing') === "1";
        clickedItem.attr('data-isFollowing', !isFollowing ? "1" : "0");
    }
});
