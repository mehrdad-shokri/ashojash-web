<div id="{{$cuisine->slug}}" class="col-sm-12 cuisine-hero "
     data-echo-background="{{action("PhotosController@getCuisinePhoto",array($cuisine->slug,500))}}">
    <div class="">
        <div class="row">
            <div class="col-xs-7 col-sm-5 col-md-4 cuisine-stick-bottom pr-0 pl-0 right-xs-40 " style="bottom: 139px;">
                <div class="col-xs-7 pl-0"><a class="see-all-collection-header hand left pl-0" href="{{action("CitiesController@allCuisines",$city->slug)}}">همه دسته بندی ها را بگردید ></a></div>
                <div class="col-xs-5 pr-0"><a class="collection-city-name-header hand "href="{{action("CitiesController@index",$city->slug)}}">{{$city->name}}</a></div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-7 col-sm-5 col-md-4 cuisine-stick-bottom pr-0 border-dark right-xs-40">
                <div class="col-xs-12  pr-0 cuisine-heading-container">
                    <h1 class="cuisine-heading">{{$cuisine->name}}</h1></div>
            </div>
        </div>
    </div>
</div>