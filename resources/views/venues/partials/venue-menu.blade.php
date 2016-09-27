@if($menus->count()==0)
    <p class="text-muted right-xs-20">منویی برای این مکان اضافه نشده است.<i class="icon ion-sad-outline"></i></p>
@else
    <div class="top-xs-40">
        @foreach($menus as $menu)
            <div class="col-xs-12 top-xs-5">
                <div class="col-md-3 col-xs-4 faNum" style="margin-top: 10px;">{{number_format($menu->price,0)}} تومان</div>

                <div class="col-md-6 col-xs-4">
                    <hr>
                </div>
                <div class="col-md-3 col-xs-4 " style="text-align: center;margin-top: 10px"><a
                            href="{{action("VenuesController@menu",$venue->slug)}}"
                            style="color: #333;text-decoration: none">{{$menu->menu_item}}</a>
                </div>

            </div>
        @endforeach
        <div class="col-xs-12 top-xs-20">
            <div class="col-xs-3 col-xs-offset-9" style="text-align: center">
                <a href="{{action("VenuesController@menu",$venue->slug)}}"><span
                            class="btn btn-primary a-primary-btn">لیست کامل</span></a>
            </div>
        </div>
    </div>
@endif
