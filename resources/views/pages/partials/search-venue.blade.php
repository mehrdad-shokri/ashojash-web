<div class="col-xs-12">
    {{--{!! Form::text('city-name', null, ['class' => 'form-control col-xs-3 ','id'=>'cityName']) !!}--}}
    <div class="top-xs-40 row">
        {!! Form::open(['action'=>'VenuesController@postClaim','method'=>"POST"]) !!}
        <div class="left col-xs-3 col-xs-offset-2 rtl-support searchFieldContainer">
            {!! Form::text('venue-name', null, ['class' => 'form-control search-input venueName','id'=>'venueName','dir'=>'rtl','placeholder'=>'نام کسب و کار']) !!}
        </div>
        <div class="left col-xs-3 rtl-support searchFieldContainer">
            {!! Form::text('city-name', null, ['class' => 'form-control col-xs-12 search-input cityName','id'=>'cityName','dir'=>'rtl','placeholder'=>'شهر']) !!}
        </div>
        {!! Form::hidden('venue-slug', null) !!}
        {!! Form::hidden('city-slug', null) !!}
        <div class="form-group col-xs-2">
            <button type="submit" class="btn btn-primary col-xs-12 search-biz-submit-btn "
                    style="font-size: 1.2em">پیدا کن<i class="fa fa-search right-xs-5"></i></button>
        </div>
        {!! Form::close() !!}
    </div>
    <div class="row col-xs-12">
        <p class="text-muted small" style="font-size: 95%"> کسب و کار خود را پیدا نمی کنید؟ از <a
                    href="{{action("PagesController@addPlace")}}">این</a> قسمت اضافه کنید. </p>
    </div>
</div>