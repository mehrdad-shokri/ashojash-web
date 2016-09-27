
@extends('admin.layout')

@section('content')
    <div class="col-sm-offset-3 col-sm-6 white-bg shadow-1">

    {!! Form::open(['action'=>'Admin\CollectionsController@store']) !!}
    <!--- City name Field --->
        <div class="form-group rtl">
            {!! Form::label('name', 'نام کلکسیون:*') !!}
            {!! Form::text('name', null, ['class' => 'form-control rtl']) !!}
        </div>

        <div class="rtl form-group">
            {!! Form::label('type', 'نوع:') !!}
            <select name="type" class="form-control">
                @foreach($types as $type=>$type_value)

                    <option value="{{$type_value}}">{{$type}}</option>
                @endforeach
            </select>
        </div>
        <div class="rtl form-group">
            {!! Form::label('type', 'شهر::') !!}
            <select name="cityId" class="form-control">
                <option value=""></option>
                @foreach($availableCities as $city)
                    <option value="{{$city->getKey()}}">{{$city->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group rtl">
            {!! Form::label('description', 'توضیحات') !!}
            {!! Form::text('description', null, ['class' => 'form-control rtl']) !!}
        </div>
        <div class="form-group rtl col-xs-4 col-xs-offset-8 p-right-0">
            <label for="date">شروع از:*</label>
            <input name="date" data-provide="datepicker" class="datepicker  form-control  ">
        </div>
        <div class="form-group rtl col-xs-6 right col-xs-offset-6 p-right-0">
            {!! Form::label('price', 'قیمت:*', ['class' => 'control-label']) !!}
            {!! Form::text('price', null, ['class' => 'form-control col-xs-6']) !!}
        </div>

        <!--- CreateCity Field --->
        <div class="form-group rtl">
            {!! Form::submit('ساخت کلکسیون', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
        @if($errors->any())
            <div class="alert alert-danger rtl">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="{!! asset("css/bootstrap-datepicker.min.css") !!}">
@stop
@section('footer.scripts')
    <script src="{!! asset("js/bootstrap-datepicker.min.js") !!}"></script>
    <script>
        $('.datepicker').datepicker();
    </script>

@stop