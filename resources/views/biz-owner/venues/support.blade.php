@extends('biz-owner.biz-owner-layout')

@section('innerContent')
    <div class="container top-buffer bottom-xs-50">
        <div class="row rtl">
            <div class="col-xs-12 float-children-right ">
                <div class="col-xs-12 col-md-5 white-bg col-xs-offset-1 shadow-1 bottom-xs-20">
                    <div class="title">
                        <h3 class="text-muted">
                            نکات پشتیبانی
                        </h3>
                    </div>
                    <div>
                        <ul>
                            <li><p style="font-size: 18px">«موضوع» را مطابق با متن ارسالی تنظیم کنید. عبارت‌هایی مانند:
                                    سؤال، کمک، راهنمایی و ... در «موضوع» مناسب نیستند.</p>
                            </li>
                            <li><p style="font-size: 18px">اگر سوالتان مربوط به کار با پنل صاحبان کسب و کار است از این
                                    فرم استفاده کنید برای سوالات عمومی می توانید از فرم تماس با ما اقدام کنید.</p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 white-bg shadow-1">
                    <div class="title text-muted"><h3>فرم پشتیبانی</h3></div>
                    {!! Form::open(['action'=>array('BusinessOwner\VenuesController@storeSupport',$venue->slug)]) !!}
                    <div class="col-xs-12 top-xs-10 form-group ">
                        <label class="col-xs-4">
                            <small class="text-danger">*</small>
                            موضوع
                        </label>

                        <div class="col-xs-8 ">
                            {!! Form::text('subject',null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-xs-12 top-xs-10 form-group ">
                        <label class="col-xs-4">
                            <small class="text-danger">*</small>
                            پیغام
                        </label>

                        <div class="col-xs-8 ">
                            {!! Form::textarea('message',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="col-xs-12 top-xs-20">
                            @include('layouts.partials.errors')
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-4"></div>
                            <div class="col-xs-8">
                                <button type="submit" class="btn btn-primary btn-success top-xs-20">ارسال</button>
                            </div>
                        </div>


                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
@stop