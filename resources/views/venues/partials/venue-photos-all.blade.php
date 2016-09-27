@foreach($photos->chunk(4) as $key=>$photoSet)
    <div class=" user-venue-photos ">
        @foreach($photoSet as $photo)
            <div class="col-xs-6 col-sm-6 col-md-3 galleryGroup">
                <a href="#" class="photo-modal galleryPopup">
                    <img src="/img/static/Preloader_normal.gif" alt=""
                         data-echo="{{action("PhotosController@getPhotoByFilename",array($photo->filename))}}">
                </a>
            </div>
        @endforeach
    </div>
@endforeach

