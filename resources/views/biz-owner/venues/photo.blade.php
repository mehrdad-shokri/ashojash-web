@extends('biz-owner.biz-owner-layout')

@section('innerContent')

    <div class="container ashojash-container">
        <div class="white-bg top-xs-30 bottom-xs-50 shadow-1 bottom-xs-50">
            <div class="row">
                <div class="col-xs-12">
                    <div class="title">
                        <h3 class="text-center">
                            تصویر کسب و کار
                        </h3>
                        <h5 class="text-muted">
                            *تصویر آپلودشده شما در صفحه اول کسب‌وکارتان نمایش داده می‌شود.
                        </h5>
                    </div>
                    <div class="col-xs-12 ">  {!! Form::open(array('class'=>'dropzone','id'=>'uploadForm','action'=>array('BusinessOwner\VenuesController@postPhoto',$venue->slug))) !!}
                        {!! Form::close() !!}
                    </div>
                    <div class="col-xs-12">
                        <h4 class="top-xs-40 text-center">
                            تصویر کنونی کسب‌وکارتان:
                        </h4>
                    </div>
                    <img src="{{action("PhotosController@getVenuePhoto",array($venue->slug,700))}}" alt=""
                         id="venue-image-container"
                         class="col-xs-12">
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer.innerScripts')
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
                        confirmButtonText: "باشه",
                        showConfirmButton: true
                    });
                })
                this.on("success", function () {
                    setTimeout(function () {
                        var d = new Date();
                        th.removeAllFiles();
                        $("#venue-image-container").attr("src", "{{(action("PhotosController@getVenuePhoto",array($venue->slug,700)))}}?" + d.getTime());
                        $("#uploadPhotoModal").modal('toggle');
                        swal({
                            title: "پایان",
                            text: "فایل با موفقیت آپلود شد",
                            type: "success",
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }, 500)
                })
            }
        }
    </script>
@stop
@section('header.innerStylesheets')
    <link rel="stylesheet" href="{{asset("css/dropzone.min.css")}}">
@stop