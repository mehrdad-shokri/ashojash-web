@extends('biz-owner.biz-owner-layout')

@section('innerContent')
    <div class="container ashjsh-container ">
        <div class="float-children-right">
            <div class="row ashjsh-row" style="    margin-right: auto;
    margin-left: auto;">

                <div class="col-xs-12 col-md-6 white-bg top-buffer shadow-1 float-children-right right-md-20">
                    <div class="">
                        <div class="title">
                            اطلاعات پایه
                            <h5 class="text-muted">
                            <span>
                            <span class="text-danger">*</span>
                              فیلدهای ستاره دار اجباریست.
                        </span>
                            </h5>
                        </div>
                        {!! Form::open(['action'=>array("BusinessOwner\InfoController@basic",$venue->slug)]) !!}
                        <div class="col-xs-12 top-xs-10 form-group ">
                            <label class="col-xs-4">
                                <small class="text-danger">*</small>
                                نام کسب و کار
                            </label>

                            <div class="col-xs-8 ">
                                {!! Form::text('name',$venue->name, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 top-xs-10">
                            <label class="col-xs-4">
                                <small class="text-danger">*</small>
                                شماره تماس رستوران:
                            </label>

                            <div class="col-xs-8">{!! Form::text('phone', $venue->phone, ['class' => 'form-control']) !!}</div>
                        </div>
                        <div class="col-xs-12 top-xs-10">
                            <label class="col-xs-4">
                                <small class="text-danger">*</small>
                                آدرس:
                            </label>

                            <div class="col-xs-8">
                                {!! Form::textarea('address', $venue->location->address, ['class' => 'form-control']) !!}
                                <button class="btn btn-primary btn-success top-xs-20" type="submit">ذخیره اطلاعات
                                </button>
                            </div>
                            <div class="col-xs-12 top-xs-10">
                                @if($errors->has('name')||$errors->has('phone')||$errors->has('address'))
                                    <div class="alert alert-danger" style="float: initial">
                                        <ul>
                                            @if($errors->has('name'))
                                                <li>{{$errors->first('name')}}</li>
                                            @endif
                                            @if($errors->has('phone'))
                                                <li>{{$errors->first('phone')}}</li>
                                            @endif
                                            @if($errors->has('address'))
                                                <li>{{$errors->first('address')}}</li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-xs-12 col-md-5 white-bg top-buffer shadow-1 left left-md-20 top-xs-20">
                    {!! Form::open(['action'=>array("BusinessOwner\InfoController@social",$venue->slug)]) !!}
                    <div class="title">
                        کسب و کار شما در شبکه های اجتماعی
                        <h5 class="text-muted">
                            <span>
                            <span class="text-danger">*</span>
                              پر کردن این قسمت الزامی نیست اما توصیه می شود
                        </span>
                        </h5>
                    </div>
                    <div class="col-xs-12 top-xs-10 ">
                        <label class="col-xs-5"><span class="fa  fa-external-link"></span> آدرس وبسایت رستوران:</label>

                        <div class="col-xs-7">{!! Form::text('url', $venue->url, ['class' => 'form-control ltr','placeholder'=>'http://yoursite.com']) !!}</div>
                    </div>
                    <div class="col-xs-12 top-xs-10">
                        <label class="col-xs-5"><span class="fa fa-instagram"></span> پیج اینساگرام:</label>

                        <div class="col-xs-7">{!! Form::text('instagram', $venue->instagram, ['class' => 'form-control ltr','placeholder'=>'http://instagram.com/yourpage']) !!}
                            <button type="submit" class="btn btn-primary btn-success top-xs-20">ذخیره اطلاعات</button>
                        </div>
                        <div class="col-xs-12 top-xs-10">
                            @if($errors->has('site')||$errors->has('instagram'))
                                <div class="alert alert-danger" style="float: initial">
                                    <ul>
                                        @if($errors->has('site'))
                                            <li>{{$errors->first('site')}}</li>
                                        @endif
                                        @if($errors->has('instagram'))
                                            <li>{{$errors->first('instagram')}}</li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="col-xs-12 col-md-5 white-bg shadow-1 left bottom-xs-20 top-xs-20 left-md-20">
                    {!! Form::open(['action'=>array("BusinessOwner\InfoController@communication",$venue->slug)]) !!}
                    <div class="title">
                        اطلاعات تماس
                        <h5 class="text-muted">
                            <span>
                            <span class="text-danger">*</span>
                              اطلاعات تماس شما نزد آشوجاش محرمانه است و برای تماس های ضروری استفاده می شود.
                        </span>
                        </h5>
                    </div>
                    <div class="col-xs-12">
                        <label class="col-xs-5"><span class="fa   fa-mobile"></span> شماره تماس موبایل:</label>

                        <div class="col-xs-7">{!! Form::text('mobile', $venue->mobile, ['class' => 'form-control ltr','placeholder'=>'09121234567']) !!}
                            <button type="submit" class="btn btn-primary btn-success top-xs-20">ذخیره اطلاعات</button>
                        </div>
                        <div class="col-xs-12 top-xs-10">
                            @if($errors->has('mobile'))
                                <div class="alert alert-danger" style="float: initial">
                                    <ul>
                                        @if($errors->has('mobile'))
                                            <li>{{$errors->first('mobile')}}</li>
                                        @endif
                                    </ul>
                                </div>
                            @endif

                        </div>

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