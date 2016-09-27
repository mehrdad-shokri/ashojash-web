<div class="col-xs-12 col-sm-12 col-md-4 col-hidden-lg  venue-card  odd shadow-2">
    <div class="thumbnail venue-image-container">
        <div class="venue-image-div">
            <div id="{{$venue->slug}}" class="venue-image venue-image-card "
                 style="background-image:url('https://ashojash.com/img/blur.jpg') "
                 data-echo-background="{{action('PhotosController@getVenuePhoto',array($venue->slug,500))}}">
                <a class="image-link" href="{{action('VenuesController@show',$venue->slug)}}"></a>
            </div>
        </div>
        <div class="venue-image-content">
            <div class="venue-info">
                <div class="venue-score {{UI::ratingClass($venue->score)}}">{{$venue->score <1 ? "-" : $venue->score}}</div>
                <p class="venue-name">{{$venue->name}}</p>
                <a class="venue-neighbor">{{$venue->name}}</a>
            </div>
        </div>
    </div>
    <div class="caption free-sans venue-caption">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-6 col-xs-offset-6 venue-cuisines">
                    @include('venues.partials.venue-cuisine')
                </div>
            </div>
        </div>
        <div class="row top-xs-5">
            <div class="col-xs-12">
                <div dir="rtl" class="col-xs-6 col-xs-offset-6">
                    <span>قیمت: </span>
                    @include('venues.partials.venue-cost')
                </div>
            </div>
        </div>
        <div class="row top-xs-5 ">
            <div class="col-xs-9 rtl venue-details faNum div-child-right">
                @if($venue->reviews->count()>0)
                    <div class="col-md-3  col-xs-2 "><a href="{{url('venue/'.$venue->slug.'#reviews')}}"
                                                        class="">{{$venue->reviews->count()}}مرور </a>
                    </div>
                @endif
                @if($venue->photos->count()>0)
                    <div class="col-md-5 col-xs-4 "><a href="{{action('VenuesController@photos',$venue->slug)}}"
                                                       class="">{{$venue->photos->count()}} عکس</a></div>
                @endif
                @if($venue->menu)
                    <div class="col-xs-3 "><a href="{{action('VenuesController@menu',$venue->slug)}}"
                                              class="parseToFarsi">منو</a></div>
                @endif
            </div>
        </div>
        <div class="row"></div>
    </div>
</div>