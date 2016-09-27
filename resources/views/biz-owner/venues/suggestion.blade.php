@extends('biz-owner.biz-owner-layout')

@section('innerContent')
    <div class="container top-buffer">
        <div class="row rtl">
            <div class="col-xs-12 float-children-right bottom-xs-50">
                <div class="col-xs-5 white-bg col-xs-offset-1 shadow-1">
                    <div class="title">
                        <h3 class="text-muted">
                            نکات پیشنهادات
                        </h3>
                    </div>
                    <div>
                        <ul>
                            <li><p style="font-size: 18px">پیشنهاد خاصی برای بهبود کیفیت خدماتمان دارید؟</p>
                            </li>
                            <li><p style="font-size: 18px">برای معرفی خدماتتان به امکانات بیشتر ی نیاز دارید که در آشوجاش نمی بینید؟درخواست دهید تا اضافه شود!</p></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-6 white-bg shadow-1">
                    <div class="title text-muted"><h3>فرم پیشنهادات</h3></div>
                    {!! Form::open(['action'=>array('BusinessOwner\VenuesController@storeSuggestion',$venue->slug)]) !!}
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