<?php

namespace App\Http\Controllers;

use App\Commands\FollowUserCommand;
use App\Commands\UnfollowUserCommand;
use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{

    public function store(Request $request, $userIdToFollow)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            if (!$user->isFollowing(User::findOrFail($userIdToFollow)) && ($user->getKey() != $userIdToFollow)) {
                $user->follow($userIdToFollow);
                return response(200);
            }
        }
        abort(500);
    }

    public function destroy(Request $request, $userIdToUnfollow)
    {

        if ($request->ajax()) {
            $user = Auth::user();
            if ($user->isFollowing(User::findOrFail($userIdToUnfollow)) && ($user->getKey() != $userIdToUnfollow)) {
                $user->unfollow($userIdToUnfollow);
                return response(200);
            }
        }
        abort(500);
    }
}
