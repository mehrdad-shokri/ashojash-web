<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>

<script>
    Dropzone.options.uploadForm = {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 4, // MB
        maxFiles: 20,
        dictDefaultMessage: "فایلتان را اینجا درگ کنید، یا کلیک کنید.",
        dictFallbackMessage: "مرورگر شما از این امکان پشتیبانی نمی کند.",
        dictInvalidFileType: "فایل آپلودی باید از نوع عکس باشد.",
        dictFileTooBig: "اندازه فایل بیش از حد مجاز است.",
        dictResponseError: "ببخشید، مشکلی رخ داد.",
        dictMaxFilesExceeded: "حداکثر بیست فایل می توانید آپلود کنید.",
        fallback: true,
        autoProcessQueue: true,
        acceptedFiles: "image/jpeg,image/png",
        init: function () {
            var th = this;
            this.on('queuecomplete', function () {
//                ImageUpload.loadImage();  // CALL IMAGE LOADING HERE
                /* setTimeout(function () {
                 }, 4000);*/
            });
            this.on("error", function () {
                setTimeout(function () {
                    th.removeAllFiles();
                }, 5000);
            })
            this.on("success", function () {
                setTimeout(function () {
                    th.removeAllFiles();
                    $("#uploadPhotoModal").modal('toggle');
                }, 4000);

            })
        }
    }


</script>