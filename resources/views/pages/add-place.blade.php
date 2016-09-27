@extends('layout')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg p0 stick-to-navbar">
            <div class="row ashjsh-row">
                <div class="col-xs-12">
                    <div class="col-xs-12">
                        <h1>محل جدید را اضافه کنید</h1>
                        <span class="text-muted top-xs-10">*فیلدهای ستاره دار اجباریست</span>

                    </div>
                    <div class="col-sm-12 col-md-8  col-md-offset-4 top-xs-40 ">
                        {!! Form::open(['action'=>"PagesController@storePlace"]) !!}
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
                                    <option value="{{$city->getKey()}}" data-lat="{{$city->lat}}"
                                            data-lng="{{$city->lng}}"
                                            @if($city->name=="تهران")selected="selected"@endif>{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-xs-12 col-md-10 col-md-offset-2">
                            {!! Form::label('g-map', 'روی نقشه',['class'=>'form-label dis-inline left-xs-5']) !!}
                            <i class="fa fa-question-circle text-muted"
                               title="مشخص کردن روی نقشه اجباری نیست اما توصیه می شود."></i>

                            <div class="col-xs-12" id="g-map" style="height: 300px"></div>
                        </div>
                        <input type="hidden" value="" id="v-lat" name="v-lat">
                        <input type="hidden" value="" id="v-lng" name="v-lng">
                        <!--- tel Field --->
                        <div class="form-group col-md-5 col-sm-9 col-sm-offset-3 col-xs-12 col-md-offset-7">
                            {!! Form::label('phone', 'شماره تماس رستوران',['class'=>'form-label']) !!}
                            {!! Form::text('phone', null, ['class' => 'form-control ltr','placeholder'=>'02198765432']) !!}
                        </div>
                        <!--- details Field --->
                        {{--<div class="form-group col-xs-12 col-md-10 col-md-offset-2">
                            {!! Form::label('details', 'جزئیات دیگر',['class'=>'form-label']) !!}
                            {!! Form::textarea('details', null, ['class' => 'form-control','style'=>'max-width: 150%;','type'=>'text','placeholder'=>'اگر نیاز به جزنیات بیشتری است از این قسمت استفاده کنید.']) !!}
                        </div>--}}

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
                            <button type="submit" class="btn btn-success ashjsh-btn-success form-group">پیشنهاد
                                اضافه
                                کردن
                            </button>

                        </div>
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer.scripts')
    {{-- google map --}}
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
        var select = $("#citySelector");
        select.on("change", function () {
            var option = $(this).find(":selected");
            var lat = option.data("lat");
            var lng = option.data("lng");
            gMap(lat, lng);
            google.maps.event.addDomListener(window, 'load', initialize(lat, lng));
        });
        var lat = select.find(":selected").data("lat");
        var lng = select.find(":selected").data("lng");
        gMap(lat, lng);
        google.maps.event.addDomListener(window, 'load', initialize(lat, lng));


        function gMap(lat, lng) {
            return new google.maps.LatLng(lat, lng);
        }
        function initialize(lat, lng) {
            var mapProp = {
                center: gMap(lat, lng),
                zoom: 13,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                disableDefaultUI: true
            };

            var map = new google.maps.Map(document.getElementById("g-map"), mapProp);

            var marker = new google.maps.Marker({
                position: gMap(lat, lng),
                draggable: true,
                map: map,
            });

            marker.setMap(map);
            google.maps.event.addListener(marker, 'dragend', function (event) {
                $("#v-lat").val(event.latLng.lat());
                $("#v-lng").val(event.latLng.lng());
            });
        }
    </script>
    <script>
        $("#city").on('dragend', function () {
            var selectOption = $(this).find(":selected");
            var lat = selectOption.attr("data-lat");
            var lng = selectOption.attr("data-lng");
            google.maps.event.addDomListener(window, 'load', initialize(lat, lng));
        })
    </script>
@stop