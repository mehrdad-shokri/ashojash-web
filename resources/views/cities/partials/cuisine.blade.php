<div class="container">
    <div class="col-xs-12">
        <h2 class="cuisine-header">{{$cuisine->motto}}
        </h2>
    </div>
    @include('cities.partials.venuelist',['venues'=>$venuesList])
    <div class="row">
        <div class="text-center" style="padding-top: 30px;">
            <a href="{{action('CitiesController@allVenuesCuisine',[$city->slug,$cuisine->slug])}}" class="ghost-btn iran-sans">
                مشاهده
                همه
            </a>
        </div>
    </div>
</div>