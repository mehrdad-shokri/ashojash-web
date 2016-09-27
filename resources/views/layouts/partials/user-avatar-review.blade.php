@if(!$user->hasProfileImg())
    <img src="/img/collection/favatar.png" alt="user-profile-pic"
         class="img-circle" style=" height: 57px; float: right">
@else
    <img src="{{(action("PhotosController@getUserAvatar",array($user->username,57)))}}"
         alt="user-profile-pic" class="img-circle" style=" float: right">
@endif