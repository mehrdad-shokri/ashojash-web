@if($review->venue->hasMainImg())
    <img class="venue-thumbnail-img"
         src="{{action('PhotosController@getVenuePhoto',array($review->venue->slug,40))}}">
@else
    <div style="height: 50px;
width: 50px;
background-color: #0B0D2A;
border-radius: 10px;"></div>
@endif
