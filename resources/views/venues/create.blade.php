@extends('layout')

@section('content')
    {!! Form::open() !!}
    <!--- Restaurant name Field --->
    <div class="form-group">
        {!! Form::label('restaurant name', 'Restaurant name:') !!}
        {!! Form::text('restaurant name', null, ['class' => 'form-control']) !!}
    </div>
        <!--- Street Address Field --->
        <div class="form-group">
            {!! Form::label('street address', 'Street Address:') !!}
            {!! Form::text('street address', null, ['class' => 'form-control']) !!}
        </div>
    <!--- Location Field --->
    <div class="form-group">
        {!! Form::label('location', 'Location:') !!}
        {!! Form::text('location', null, ['class' => 'form-control']) !!}
    </div>


    {!! Form::close() !!}
@stop