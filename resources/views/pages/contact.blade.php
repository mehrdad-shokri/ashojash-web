@extends('layout')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg p0 stick-to-navbar">
            @include('pages.partials.contact-hero')
            <div class="container ashjsh-container">
                <div class="row ashjsh-row text-center">
                    {!! Form::open() !!}
                    <div class="col-sm-12 col-md-8 top-xs-40 rtl contact-container">
                        <!--- name Field --->
                        <div class="form-group col-xs-12">
                            {!! Form::text('name', null, ['class' => 'form-control ','placeholder'=>'نام*']) !!}
                        </div>
                        <div class="form-group col-xs-12">
                            {!! Form::email('email', null, ['class' => 'form-control input-rtl','placeholder'=>'ایمیل*']) !!}
                        </div>
                        <div class="form-group col-xs-12">
                            {!! Form::text('', null, ['class' => 'form-control ','placeholder'=>"شماره تماس (اختیاری)"]) !!}
                        </div>
                        <div class="form-group col-xs-12">
                            {!! Form::textarea('message', null, ['class' => 'form-control max-w-fill','placeholder'=>'پیام*']) !!}
                        </div>
                        <div class="col-xs-12 top-xs-20">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>

                        <div class="form-group col-xs-12 ">
                            {!! Form::submit('ارسال', ['class' => 'btn btn-success ashjsh-btn-success','style'=>'width:100px']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    </div>
@stop
@section('footer.scripts')
    <script src="/js/async-loader.js"></script>
    <script>
        $(document).ready(function () {
            echo.init({
                offset: 600,
                throttle: 250,
                unload: false,
            });
        });
    </script>
@stop