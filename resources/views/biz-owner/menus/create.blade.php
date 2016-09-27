@extends('biz-owner.biz-owner-layout')

@section('innerContent')
    @include('biz-owner/partials/venue-nav')
    <div class="container ashjsh-container white-bg top-buffer shadow-1 bottom-xs-50"
         style="min-height: 330px; width: 50%">
        <h3 class="text-center ">
            آیتم جدید
        </h3>
        {!!  Form::open(['action' =>array( "BusinessOwner\MenusController@create",$venue->slug)])  !!}
        @include('biz-owner.partials.menu-fields')
        <div class="row">
            <div class="col-xs-12 rtl" style="margin-top: 40px;margin-bottom: 40px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i>
                    اضافه کن
                </button>
            </div>
            <a href="{{action('BusinessOwner\MenusController@all',$venue->slug)}}"
               class="btn btn-primary col-xs-12"><span
                        class="fa fa-check-circle"></span> <span>
                        بازگشت به لیست منو
                    </span></a>
        </div>
        {!! Form::close() !!}
    </div>
@stop


@section('header.innerStylesheets')
    <link rel="stylesheet" href="/css/jquery.timepicker.css">
@stop
@section('footer.innerScripts')
    <script src="/js/menu.js"></script>
    {{-- <script type="text/javascript">
         window.setTimeout(function() {
             $("#flash_placeholder").fadeTo(500, 0).slideUp(500, function(){
                 $(this).remove();
             });
         }, 3000);
     </script>--}}

@stop