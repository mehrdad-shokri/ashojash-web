<div class="col-xs-12 right-xs-40" style="padding-bottom: 20px;" id="reviews-container">
    @foreach($reviews as $review)
        <div class="col-xs-12 top-xs-20 review">
            <div>
                <div class="col-xs-12 float-children-right pr-0 pb-5 review-header pull-right">
                    <div class="pr-0 pl-0 left-xs-20">
                        <a href="{{action("UsersController@show",$review->user->username)}}">
                            @include('layouts.partials.user-avatar-review',["user"=>$review->user])
                        </a>
                    </div>
                    <div class=" pr-0 right-xs-5 right-xs-only-20">
                        <div class="col-xs-12 pr-0"><p
                                    class="">{{$review->user->name}}</p></div>
                        <div class="col-xs-12 pr-0"><a href="{{action("UsersController@show",$review->user->username)}}"
                                                       style="color: #2d2d2d;text-decoration: none">
                                <p>{{$review->user->username}}</p></a></div>

                    </div>
                </div>

                <div class="col-xs-12 pr-0 pull-right" style="    border-bottom: 4px solid #f0f0f0;
    padding-bottom: 5px;">
                    <i class="text-muted faNum" style="font-size: 12px">{{$review->updated_at->diffForHumans()}}</i>

                    <div class="top-xs-5">
                        <p class="rtl">

                        <span class="score-container" data-toggle="tooltip" data-placement="bottom"
                              title="میانگین" id="score-container">


                            امتیاز
                            <i class="score {{UI::ratingClass($review->reviewAve())}}" style="">
                                {{$review->reviewAve()}}</i>
                        </span>
                        <span>{{$review->comment}}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="ltr simple-paginator-container" id="simple-paginator-container">
    {!! $reviews->render() !!}
</div>