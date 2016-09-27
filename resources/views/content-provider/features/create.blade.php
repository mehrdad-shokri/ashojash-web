@extends('admin.layout')

@section('content')
    <div class="col-sm-offset-3 col-sm-6 white-bg shadow-1">

        {!! Form::open(['action'=>'Admin\FeaturesController@store']) !!}
                <!--- City name Field --->
        <div class="form-group">
            {!! Form::label('name', 'Feature name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control rtl']) !!}
        </div>
        <!--- CreateCity Field --->
        <div class="form-group top-xs-40">
            {!! Form::submit('create feature', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop