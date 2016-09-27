@extends('admin.layout')

@section('content')
    <div class="col-sm-offset-3 col-sm-6 white-bg shadow-1">

        {!! Form::open(array('method'=>'put','action'=>array('admin\RolesController@update',$role->id))) !!}
                <!--- City name Field --->
        <div class="form-group">
            {!! Form::label('name', 'Role name:') !!}
            {!! Form::text('name', $role->name, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('display-name', 'Display name:') !!}
            {!! Form::text('display-name', $role->display_name, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Description:') !!}
            {!! Form::text('description', $role->description, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-6 top-xs-40">
            <div class="form-group">
                {!! Form::submit('update role', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>

        <div class="col-md-6 top-xs-40">
            {!! Form::open(array('method'=>'delete','action'=>array('admin\RolesController@delete',$role->id))) !!}
            <div class="form-group">
                {!! Form::submit('delete', ['class' => 'btn btn-danger']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop