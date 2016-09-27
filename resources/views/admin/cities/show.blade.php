@extends('admin.layout')

@section('content')
    <div class="shadow-1 col-xs-12 white-bg bor-ra-10">
        <div class="col-xs-3">
            <i class="icon {{$city->status==0?"ion-eye-disabled":"ion-eye"}} hand " data-city-status="{{$city->status}}"
               id="toggleCityStatus"
               data-city-id="{{$city->getKey()}}" style="font-size: 20px;"></i>
        </div>
        <div class="col-xs-9">  {!! Form::open(array('class'=>'dropzone','action'=>array('Admin\CitiesController@addCityPhoto',$city->slug))) !!}
            {!! Form::close() !!}</div>
        <div class="col-xs-12 top-xs-40">
            <div class="col-xs-12 col-md-6 ">
                <div class="row">
                    {!! Form::open(['action'=>array("Admin\CitiesController@update",$city->slug),'method'=>"patch"]) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'City name:') !!}
                        {!! Form::text('name', $city->name, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('lat', 'Latitude:') !!}
                        {!! Form::text('lat', $city->lat, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('lng', 'Longitude:') !!}
                        {!! Form::text('lng', $city->lng, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group" style="direction: rtl">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::submit('update', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <img src="{{action('PhotosController@getCityPhoto',$city->slug)}}" style="max-width: 100%" alt="">
            </div>

        </div>

    </div>
@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="{{asset("css/dropzone.min.css")}}">
@stop
@section('footer.scripts')
    <script src="{{asset("js/dropzone.min.js")}}"></script>
    <script>
        $("#toggleCityStatus").on("click", function () {
            var status = $(this).attr('data-city-status');
            var cityId = $(this).attr("data-city-id");
            var cityToggleBtn = $(this);
            if (parseInt(status) == 1)
                swal({
                            title: "Are you sure?",
                            text: "You wanna make city unavailable?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, continue.",
                            closeOnConfirm: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
//                                send ajax
//                                on success show succes and
//                                on error show error button
                                $.ajax("/admin/city/toggle-status/" + cityId, {
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    beforeSend: function () {

                                    },
                                    dataType: "json",
                                    success: function (data) {
                                        swal({
                                            title: "Success",
                                            text: "City made unavailable.",
                                            type: "success",
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                        unavailableCity(cityToggleBtn);
                                    },
                                    error: function () {
                                        //show error
                                        swal({
                                            title: "Error",
                                            text: "Something went wrong...",
                                            type: "error",
                                            confirmButtonText: 'Ok',
                                            showConfirmButton: true
                                        });
                                    },
                                    type: "POST"
                                });
                            }
                        });
            else
                swal({
                            title: "Are you sure?",
                            text: "You wanna make city available",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, go on.",
                            closeOnConfirm: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax("/admin/city/toggle-status/" + cityId, {
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    beforeSend: function () {
                                    },
                                    dataType: "json",
                                    success: function (data) {
                                        swal({
                                            title: "Success",
                                            text: "City made available.",
                                            type: "success",
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                        availableCity(cityToggleBtn);
                                    },
                                    error: function () {
                                        //show error
                                        swal({
                                            title: "Error",
                                            text: "Something went wrong...",
                                            type: "error",
                                            confirmButtonText: 'Ok',
                                            showConfirmButton: true
                                        });
                                    },
                                    type: "POST"
                                });

                            }
                        });
        });
        function unavailableCity(cityToggleBtn) {
            cityToggleBtn.addClass("ion-eye-disabled");
            cityToggleBtn.removeClass("ion-eye");
            cityToggleBtn.attr("data-city-status", 0);
        }
        function availableCity(cityToggleBtn) {
            cityToggleBtn.removeClass("ion-eye-disabled");
            cityToggleBtn.addClass("ion-eye");
            cityToggleBtn.attr("data-city-status", 1);
        }
    </script>
@stop
