var banBtn = $("#banUser")
var isBanned = banBtn.attr("data-user-isBanned");
var bannedSentence = "بن شده";
var notBannedSentence = "عادی";
if (parseInt(isBanned) == 0) {
    banBtn.text(notBannedSentence)
    banBtn.addClass('follow-btn')
}
else {
    banBtn.text(bannedSentence);
    banBtn.addClass('btn-danger')
}

$("#banUser").on('click', function () {
    var userId = $(this).attr("data-user-id");
    var isBanned = banBtn.attr("data-user-isBanned");
    if (parseInt(isBanned) == 0)
        swal({
                title: "Are you sure?",
                text: "You wanna ban this user?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, ban.",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
//                                send ajax
//                                on success show succes and
//                                on error show error button
                    $.ajax("/owner/user/toggle-ban/" + userId, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {

                        },
                        dataType: "json",
                        success: function (data) {
                            swal({
                                title: "Success",
                                text: "User banned temporarily.",
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            bannedBtn(banBtn);
                        },
                        error: function () {
                            //show error
                            swal({
                                title: "Error",
                                text: "Something went wrong...",
                                type: "error",
                                confirmButtonText: 'Ok',
                                showConfirmButton: true
                            });
                        },
                        type: "POST"
                    });
                }
            });
    else
        swal({
                title: "Are you sure?",
                text: "You wanna permit the user?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, permit.",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax("/owner/user/toggle-ban/" + userId, {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                        },
                        dataType: "json",
                        success: function (data) {
                            swal({
                                title: "Success",
                                text: "User permitted temporarily.",
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        },
                        error: function () {
                            //show error
                            swal({
                                title: "Error",
                                text: "Something went wrong...",
                                type: "error",
                                confirmButtonText: 'Ok',
                                showConfirmButton: true
                            });
                        },
                        type: "POST"
                    });
                    notBannedBtn(banBtn);
                }
            });
});
function notBannedBtn(btn) {
    banBtn.text(notBannedSentence);
    banBtn.attr("data-user-isBanned", 0);
    banBtn.removeClass("btn-danger");
    banBtn.addClass('btn-success');
}
function bannedBtn(btn) {
    banBtn.text(bannedSentence);
    banBtn.attr("data-user-isBanned", 1);
    banBtn.removeClass("btn-success");
    banBtn.addClass('btn-danger');
}