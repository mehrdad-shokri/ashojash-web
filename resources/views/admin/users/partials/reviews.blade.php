<div class=" rtl">
    <div class="row ">
        <div class="col-xs-12 top-only-xs-20">
            <h4 class="review-heading right-xs-20">نظرات {{$user->name}} </h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="right-xs-40" style="border-bottom: 2px solid #f0f0f0;
    padding-bottom: 20px;" id="reviews-container">
                @foreach($reviews as $review)
                    <div class="row top-xs-40 review " data-review-id="{{$review->getKey()}}">

                        <div>
                            <div class="col-xs-9 float-children-right  pr-0  pb-5 review-header pull-right">
                                <div class="col-xs-2 col-sm-2 col-md-1 pr-0 pl-0 ">
                                    <a href="{{action("VenuesController@show",$review->venue->slug)}}">
                                        @include('venues.partials.venue-avatar-normal')
                                    </a>
                                </div>
                                <div class="col-xs-9 col-sm-9 col-md-10 pr-0 right-xs-20">
                                    <div class="col-xs-12 pr-0"><a href="{{action("VenuesController@show",$review->venue->slug)}}"
                                                                   style="color: #2d2d2d;text-decoration: none">
                                            <span>{{$review->venue->name}}</span></a></div>
                                    <div class="col-xs-12 pr-0"><a
                                                href="{{action("CitiesController@index",$review->venue->city()->slug)}}"><span
                                                    class="item-city text-muted">{{$review->venue->city()->name}}</span></a></div>
                                </div>
                            </div>
                            <div class="col-xs-9 pr-0 pull-right" style="    border-bottom: 4px solid #f0f0f0;
    padding-bottom: 5px;">
                                <i class="text-muted" style="font-size: 12px">{{$review->updated_at->diffForHumans()}}</i>

                                <div class="top-xs-5">
                                    <p class="rtl">

                        <span class="score-container" data-toggle="tooltip" data-placement="bottom"
                              title="میانگین" id="score-container">


                            امتیاز
                            <i class="score {{UI::ratingClass($review->reviewAve())}}" style="">
                                {{$review->reviewAve()}}</i>
                        </span>


                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                        eiusmod
                                        tempor incididunt ut
                                        labore
                                        et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                                        nisi
                                        ut
                                        aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                                        esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt
                                        in
                                        culpa qui officia deserunt mollit anim id est laborum.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
                <div class="ltr">
                    {!! $reviews->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>