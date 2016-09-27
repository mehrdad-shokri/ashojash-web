@extends('biz-owner.biz-owner-layout')

@section('innerContent')

    <div class="container ashojash-container">
        <div class="white-bg top-xs-30 bottom-xs-50 shadow-1 bottom-xs-50">
            <div class="row">
                <div class="col-xs-12">
                    {!! Form::open(['action'=>array("BusinessOwner\VenuesController@storeSchedule",$venue->slug)]) !!}
                    <div class="title">
                        <h3 class="text-center">
                            ساعات کار
                        </h3>
                        <h5 class="text-muted">
                            <span>
                            <span class="text-danger">*</span>
                             ساعات کار شما در صفحه اول کسب و کارتان نشان داده خواهد شد.
                        </span>
                        </h5>
                    </div>
                    <div class="col-xs-12">
                        <div class="">
                            @include('biz-owner.partials.working-hour')
                        </div>
                        <div class="col-xs-12 top-xs-40">
                            @if (count($errors) > 0)

                                <div class="alert alert-danger">
                                    <ul class="">
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-edit"></i> به روزرسانی کن
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer.innerScripts')
    <script src="/js/add-clock-picker.js"></script>
    <script src="/js/jquery.timepicker.min.js"></script>
@stop
@section('header.innerStylesheets')
    <link rel="stylesheet" href="/css/jquery.timepicker.css">
@stop