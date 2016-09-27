@foreach($menus as $menu)
    <div class="col-xs-12 top-xs-5">
        <div class="col-md-3 col-xs-4 faNum text-center" style="margin-top: 10px;">{{number_format($menu->price,0)}}
            تومان
        </div>
        <div class="col-md-6 col-xs-4">
            <hr>
        </div>
        <div class="col-md-3 col-xs-4 menu-item-name">{{$menu->menu_item}}
        </div>
        <div class="col-xs-12 top-xs-10 menu-item-ingredients text-muted faNum">
            {{$menu->ingredients}}
        </div>
    </div>
@endforeach