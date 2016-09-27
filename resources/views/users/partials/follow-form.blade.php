@if($currentUser)
    @if(!$currentUser->is($user))
        @if($user->isFollowedBy($currentUser))
            {!! Form::open(array('action'=>['FollowersController@destroy',$user->id],'method'=>'delete'))!!}
            <button type="submit" class="btn btn-danger">unfollow {{$user->name}}</button>
            {!! Form::close() !!}
        @else
            {!! Form::open(array('action'=>['FollowersController@store',$user->id])) !!}
            <button type="submit" class="btn ">follow {{$user->name}}</button>
            {!! Form::close() !!}
        @endif
    @endif
@endif