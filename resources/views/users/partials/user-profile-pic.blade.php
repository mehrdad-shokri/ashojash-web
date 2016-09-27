<div class="top-xs-20">
    @if($currentUser && $user->getKey()==$currentUser->getKey())
        <a href="#" class="profile-img-link darken" id="upload_photo" data-toggle="modal"
           data-target="#uploadPhotoModal">
            @include('layouts.partials.user-avatar-normal')
            <p class="text" >ویرایش تصویر</p></a>
    @else
        @include('layouts.partials.user-avatar-normal')
    @endif
</div>