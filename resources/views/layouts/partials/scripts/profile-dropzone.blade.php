{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css"/>--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>--}}
<link rel="stylesheet" href="{{asset("css/dropzone.min.css")}}">
<script src="{{asset("js/dropzone.min.js")}}"></script>
<script>
    Dropzone.options.uploadForm = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 4, // MB
        maxFiles: 1,
        dictDefaultMessage: "فایلتان را اینجا درگ کنید، یا کلیک کنید.",
        dictFallbackMessage: "مرورگر شما از این امکان پشتیبانی نمی کند.",
        dictInvalidFileType: "فایل آپلودی باید از نوع عکس باشد.",
        dictFileTooBig: "اندازه فایل بیش از حد مجاز است.",
        dictResponseError: "ببخشید، مشکلی رخ داد.",
        dictMaxFilesExceeded: "حداکثر یک فایل می توانید آپلود کنید.",
        fallback: true,
        autoProcessQueue: true,
        acceptedFiles: "image/jpeg,image/jpg,image/png",
        init: function () {
            var th = this;
            this.on('queuecomplete', function () {
//                ImageUpload.loadImage();  // CALL IMAGE LOADING HERE


                /* setTimeout(function () {

                 }, 4000);*/
            })
            this.on("error", function () {
                setTimeout(function () {
                    th.removeAllFiles();
                }, 5000);
                swal({
                    title: "خطا",
                    text: "خطایی در آپلود تصویر پروفایلتان رخ داد",
                    type: "error",
                    confirmButtonText:"باشه",
                    showConfirmButton: true
                });
            })
            this.on("success", function () {
                setTimeout(function(){
                    var d = new Date();
                    th.removeAllFiles();
                    $("#profile-image-container").attr("src", "{{(action("PhotosController@getUserAvatar",array($user->username,200)))}}?" + d.getTime());
                    $("#uploadPhotoModal").modal('toggle');
                    swal({
                        title: "پایان",
                        text: "فایل با موفقیت آپلود شد",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                },500)
            })
        }
    }
</script>