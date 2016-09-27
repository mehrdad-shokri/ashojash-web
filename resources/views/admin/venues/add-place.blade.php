@extends('admin.layout')

@section('content')
    <div class="box rtl">
        <div class="box-header">
            <h1>محل جدید را اضافه کنید</h1>
            <span class="text-muted top-xs-10">*فیلدهای ستاره دار اجباریست</span>
        </div>
        <div class="box-body">
            <div class="row ashjsh-row">
                <div class="col-xs-12">

                    <div class="col-sm-12 col-md-8  col-md-offset-4 top-xs-40 ">
                        {!! Form::open(['action'=>"Admin\VenuesController@store"]) !!}
                                <!--- Restaurant name Field --->

                        <div class="form-group">
                            <div class="col-xs-12 col-md-5 col-md-offset-7 form-group">
                                {!! Form::label('name', 'نام محل*',['class'=>'form-label']) !!}
                                {!! Form::text('name', null, ['class' => 'form-control ']) !!}
                            </div>
                        </div>
                        <div class=" col-xs-12 col-md-10 col-md-offset-2 ">
                            <!--- Street address Field --->
                            <div class="form-group">
                                {!! Form::label('address', 'نشانی*',['class'=>'form-label']) !!}
                                {!! Form::text('address', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <!--- location Field --->
                        <div class="form-group col-md-5 col-sm-9 col-sm-offset-3 col-xs-12 col-md-offset-7 ">
                            {!! Form::label('city', 'شهر*',['class'=>'form-label']) !!}

                            <select name="city" id="citySelector" class="form-control">
                                @foreach($availableCities
                                 as $city)
                                    <option value="{{$city->getKey()}}"
                                    >{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <!--- lat Field --->
                            <div class="form-group">
                                {!! Form::label('lat', 'lat:') !!}
                                {!! Form::text('lat', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <!--- lng Field --->
                            <div class="form-group">
                                {!! Form::label('lng', 'lng:') !!}
                                {!! Form::text('lng', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        @if($errors->any())
                            <div class="col-xs-12 top-xs-20 col-md-10 col-md-offset-2">
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <div class="col-xs-12 top-xs-20 p-bottom-20">
                            <button type="submit" class="btn btn-success ashjsh-btn-success form-group">اضافه کن</button>

                        </div>
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer.scripts')

@stop