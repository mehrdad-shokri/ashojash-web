@if(!$user->hasProfileImg())
    <img src="/img/collection/favatar.png" alt="user-profile-pic"
         class="img-circle" id="profile-image-container">
@else
    <img src="{{(action("PhotosController@getUserAvatar",array($user->username,200)))}}"
         alt="user-profile-pic" class="img-circle" id="profile-image-container">
@endif