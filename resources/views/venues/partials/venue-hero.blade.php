<div id="{{$venue->slug}}" class="col-sm-12 venue-hero "
     data-echo-background="{{action("PhotosController@getVenuePhoto",array($venue->slug,400))}}">
    <div class="row">
        <div class="col-xs-8 rtl  venue-stick-bottom  underline-dark ">
            <div class="col-xs-2 ">
                <div class="center-block row venue-score-main {{UI::ratingClass($venue->score)}}">
                    {{$venue->score <1 ? "-" : $venue->score}}
                </div>
                <div class="row text-center faNum"><b>{{UI::getReviewCountStateFa($venue)}}</b>
                </div>
            </div>

            <div class="col-xs-10 venue-heading-container">
                <h1 class="venue-heading">{{$venue->name}}</h1></div>
        </div>
    </div>
</div>