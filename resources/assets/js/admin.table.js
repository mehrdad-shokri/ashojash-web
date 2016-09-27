jQuery(document).ready(function ($) {
    $(".clickable-row").click(function () {
        window.open($(this).data('href'), '_blank');
    });
    $(".clickable-row").hover(function () {
        $(this).toggleClass("active");
        $(this).css('cursor', 'pointer');
        $(".clickable-row .delete-btn").toggleClass("hidden");
    });

    $(".clickable-row .delete-btn").click(function (e) {
        var photoId = $(this).attr('data-photo-id');
        deletePhoto(photoId, -1);
        e.stopPropagation();
    });
});
function deletePhoto(permissionId, roleId) {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
        swal.disableButtons();
        $.ajax({
            url: "scriptDelete.php",
            type: "POST",
            data: {
                id: 5
            },
            dataType: "html",
            success: function () {
                swal("Done!", "It was succesfully deleted!", "success");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal("Error deleting!", "Please try again " + ajaxOptions, "error");
            }
        });
    });
}
//# sourceMappingURL=admin.table.js.map