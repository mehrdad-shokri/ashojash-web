@extends('biz-owner.biz-owner-layout')

@section('innerContent')

    <div class="container ashojash-container">
        <div class="white-bg top-xs-30 bottom-xs-50 shadow-1 bottom-xs-50">
            <div class="row">
                <div class="col-xs-12">
                    <div class="title">
                        <h3 class="text-center">
                            کسب و کارتان در نقشه
                        </h3>
                        <h5 class="text-muted">
                            *کسب و کار خود را روی نقشه مشخص کنید، تا شانس دیده‌شدنتان چندین برابر شود.
                        </h5>
                    </div>
                    {!! Form::open(['action'=>array('BusinessOwner\VenuesController@postMap',$venue->slug),'method'=>'post']) !!}
                    <div class="form-group col-xs-12">
                        <div class="col-xs-12" id="g-map" style="height: 300px"></div>
                        <input type="hidden" value="" id="v-lat" name="v-lat">
                        <input type="hidden" value="" id="v-lng" name="v-lng">
                    </div>
                    <div class="form-group col-xs-12">
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
                    <div class="form-group col-xs-12">
                        {!! Form::submit('ذخیره کن', ['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer.innerScripts')
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script>
        var lat = "{{$lat}}";
        var lng = "{{$lng}}"
        var venueCenter = gMap(lat, lng);

        google.maps.event.addDomListener(window, 'load', initialize(lat, lng));


        function gMap(lat, lng) {
            return new google.maps.LatLng(lat, lng);
        }
        function initialize(lat, lng) {

            var mapProp = {
                center: gMap(lat, lng),
                zoom: parseInt("{{$zoom}}"),
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