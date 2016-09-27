@extends('biz-owner.biz-owner-layout')

@section('innerContent')
    <div class="container ashjsh-container ">
        <div class="row ashjsh-row" style="    margin-right: auto;    margin-left: auto;">
            <div class="float-children-right">

                <div class="col-xs-12  white-bg top-buffer shadow-1 bottom-xs-20">
                    <div class="col-xs-12">
                        اطلاعات پایه
                        <h5 class="text-muted">
                            <span>
                            <span class="text-danger">*</span>
                              فیلدهای ستاره دار اجباریست.
                        </span>
                        </h5>
                    </div>
                    {!! Form::open(['action'=>array("Admin\VenuesController@uploadPhotos",$venue->slug)]) !!}
                    <div class="col-xs-12 top-xs-20 form-group p-right-0">
                        <label class="col-xs-12">
                            <small class="text-danger">*</small>
                            آدرس را وارد کنید
                        </label>
                        <div class="col-xs-12">
                            {!! Form::text('id',"", ['class'=> 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12">
                        @if($errors->any())
                            <div class="alert alert-danger" style="float: initial">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-xs-12">
                        <button class="btn btn-primary btn-success top-xs-20" type="submit">آپلود کن</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('header.innerStylesheets')
    <link rel="stylesheet" href="/css/jquery.timepicker.css">
@stop
@section('footer.innerScripts')

    <script type="text/javascript">
        window.setTimeout(function () {
            $("#flash_placeholder").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 3000);
    </script>

@stop