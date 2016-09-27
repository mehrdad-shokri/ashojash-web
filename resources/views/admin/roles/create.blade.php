@extends('admin.layout')

@section('content')
    <div class="col-sm-offset-3 col-sm-6">
        {!! Form::open(['action'=>'Admin\RolesController@store']) !!}
                <!--- City name Field --->
        <div class="form-group">
            {!! Form::label('name', 'Role name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <!--- Display Name Field --->
        <div class="form-group">
            {!! Form::label('display_name', 'Display Name:') !!}
            {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
        </div>
        <div>
            <!--- Description Field --->
            <div class="form-group">
                {!! Form::label('description', 'Description:') !!}
                {!! Form::text('description', null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <!--- CreateCity Field --->
        <div class="form-group">
            {!! Form::submit('create city', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop