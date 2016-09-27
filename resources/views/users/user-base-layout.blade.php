@extends('layout')

@section('content')
    <div class="container ashjsh-container">
        <div class="white-bg p0 stick-to-navbar">
            <div class="row p-bottom-20" style="margin-right: 0;margin-left: 0">
                <div class="col-xs-12">
                    <div class="col-xs-12 col-sm-4 col-md-3 right txt-middle-xs-only">
                        @include('users.partials.thumbnail')
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9 right top-only-xs-20">
                        @yield('innerContent')
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="/css/user-profile.css">
    @yield('header.innerStylesheets')
@stop
@section('footer.scripts')
    <script type="text/javascript">
        @if($errors->any())
        swal({
                    title: "خطا",
                    text: "خطایی در آپلود تصویر پروفایلتان رخ داد",
                    type: "error",
                    confirmButtonText: "باشه",
                    showConfirmButton: true
                });
        @endif
    </script>
    @include('layouts.partials.scripts.profile-dropzone')
    @yield('footer.innerScripts')
    {{UI::setTimeDefault()}}
@stop