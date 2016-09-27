@extends('admin.layout')

@section('content')
    <div class="col-sm-offset-3 col-sm-6 white-bg shadow-1">

        {!! Form::open(array('method'=>'put','action'=>array('Admin\FeaturesController@update',$features->id))) !!}
                <!--- City name Field --->
        <div class="form-group">
            {!! Form::label('name', 'Feature name:') !!}
            {!! Form::text('name', $features->name, ['class' => 'form-control rtl']) !!}
        </div>
        <div class="col-md-6 top-xs-40">
            <div class="form-group">
                {!! Form::submit('update feature', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>

        <div class="col-md-6 top-xs-40">
            {!! Form::open(array('method'=>'delete','action'=>array('Admin\FeaturesController@delete',$features->id))) !!}
            <div class="form-group">
                {!! Form::submit('delete', ['class' => 'btn btn-danger']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop