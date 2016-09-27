<?php

namespace App\Http\Controllers;


use App\User;

trait FollowableTrait
{
    public function follows()
    {
        return $this->belongsToMany(static::class, 'follows', 'follower_id', 'followed_id')->withTimeStamps();
    }

    /**
     * Users, Followed by The currentUser
     */
    public function followers()
    {
        return $this->belongsToMany(static::class, 'follows', 'followed_id', 'follower_id')->withTimeStamps();
    }

    public function follow($userIdToFollow)
    {
        $this->follows()->attach($userIdToFollow);
    }

    public function unfollow($userIdToUnfoloow)
    {
        $this->follows()->detach($userIdToUnfoloow);
    }

    public function isFollowedBy(User $user)
    {
        $users = $this->followers()->lists('follower_id');
        return in_array($user->id, $users->toArray());
    }

    public function isFollowing(User $user)
    {
        $users = $this->follows()->pluck('followed_id');
        return in_array($user->id, $users->toArray());
    }
}