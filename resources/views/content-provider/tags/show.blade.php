@extends('admin.layout')

@section('content')
    <div class="col-sm-offset-3 col-sm-6 white-bg shadow-1">

        {!! Form::open(array('method'=>'put','action'=>array('Admin\TagsController@update',$tags->id))) !!}
                <!--- City name Field --->
        <div class="form-group">
            {!! Form::label('name', 'Tag name:') !!}
            {!! Form::text('name', $tags->name, ['class' => 'form-control rtl']) !!}
        </div>
        <div class="col-md-6 top-xs-40">
            <div class="form-group">
                {!! Form::submit('update tag', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>

        <div class="col-md-6 top-xs-40">
            {!! Form::open(array('method'=>'delete','action'=>array('Admin\TagsController@delete',$tags->id))) !!}
            <div class="form-group">
                {!! Form::submit('delete', ['class' => 'btn btn-danger']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop