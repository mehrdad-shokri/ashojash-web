<div class="item-list">
    <div class="col-xs-12 rtl">
        <div class="row ">
            @foreach($venues as $venue)
                @include('cities.partials.venue')
            @endforeach
        </div>
    </div>
</div>
