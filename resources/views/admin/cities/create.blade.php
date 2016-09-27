<?php $page_title = 'create city' ?>

@extends('admin.layout')
@section('content')
    <div class="col-sm-offset-3 col-xs-12 col-md-6 shadow-1 bor-ra-10 p-20" style="background-color: #fff">
        {!! Form::open(['action'=>'Admin\CitiesController@store']) !!}
                <!--- City name Field --->
        <div class="form-group">
            {!! Form::label('name', 'City name:') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <!--- CreateCity Field --->
        <div class="form-group">
            {!! Form::submit('create city', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
@stop