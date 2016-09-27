@extends('admin.layout')

@section('content')
    <div class="col-sm-offset-2 col-sm-8 col-xs-12 white-bg shadow-1">
        <div class="col-xs-12 p-bottom-50">  {!! Form::open(array('class'=>'dropzone','action'=>array('Admin\CuisinesController@addCuisinePhoto',$cuisine->slug))) !!}
            {!! Form::close() !!}</div>
        {!! Form::open(array('method'=>'put','action'=>array('ContentProvider\CuisinesController@update',$cuisine->id))) !!}
                <!--- Cuisine Motto Field --->
        <div class="col-xs-12">
            <img src="{{action("PhotosController@getCuisinePhoto",array($cuisine->slug,300))}}" class="col-xs-12"
                 alt="">
        </div>
        <div class="form-group">
            {!! Form::label('motto', 'Cuisine Motto:') !!}
            {!! Form::text('motto', $cuisine->motto, ['class' => 'form-control rtl']) !!}
        </div>

        <!--- Cuisine name Field --->
        <div class="form-group p-top-30">
            {!! Form::label('name', 'Cuisine name:') !!}
            {!! Form::text('name', $cuisine->name, ['class' => 'form-control rtl']) !!}
        </div>

        {{-- <div class="col-md-6 col-xs-12  ">  {!! Form::open(array('class'=>'dropzone','action'=>array('Admin\CuisinesController@addCuisinePhoto',$cuisine->slug))) !!}
             {!! Form::close() !!}</div>--}}
        <div class="form-group p-top-30">
            <label for="firstPage">First page</label>
            <br>
            <input type="checkbox" name="firstPage" {{$cuisine->first_page==1?"checked":""}}>
        </div>

        <div class="col-md-6 top-xs-40">
            <div class="form-group">
                {!! Form::submit('update cuisine', ['class' => 'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>

        <div class="col-md-6 top-xs-40">
            {!! Form::open(array('method'=>'delete','action'=>array('ContentProvider\CuisinesController@delete',$cuisine->id))) !!}
            <div class="form-group">
                {!! Form::submit('delete', ['class' => 'btn btn-danger']) !!}
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@stop
@section('footer.scripts')
    <script src="{{asset("js/dropzone.min.js")}}"></script>
@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="{{asset("css/dropzone.min.css")}}">
@stop