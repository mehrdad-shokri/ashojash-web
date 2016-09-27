@if($photos->count()==0)
    <p class="text-muted right-xs-20"> تصویری برای این مکان یافت نشد. <i class="icon ion-sad-outline"></i></p>
@else
    <div class="col-xs-12 p-right-20 p-left-20 top-xs-20">
        @foreach($photos->chunk(6) as $key=>$photoSet)
            <div class="row user-photos-photos">
                @foreach($photoSet as $photo)
                    <div class="col-xs-6 col-sm-6 col-md-2 galleryGroup">
                        <a href="#" class="photo-modal galleryPopup">
                            <img src="/img/static/Preloader_normal.gif" class="venue-photo" alt=""
                                 data-echo="{{action("PhotosController@getPhotoByFilename",array($photo->filename))}}">
                        </a>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
        <div class="col-xs-6 col-sm-5 col-md-2 photo-more photoGroup"><a
                    href="{{action("VenuesController@photos",$venue->slug)}}"
                    class="photo-modal">
                <div>{{$venue->photos->count()}}+</div>
            </a>
        </div>
        <div class="col-xs-6 col-sm-5 col-md-2 photo-more photoGroup hand">
            <a
                    href="#"
                    class="photo-modal" data-toggle="modal"
                    data-target="#uploadPhotoModal">
                <div style="font-size: .75em">اضافه کردن تصویر</div>
            </a></div>


@endif

