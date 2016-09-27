<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class TwitterOauthController extends Controller implements OAuth
{

    function redirectProvider()
    {
        return Socialite::driver('twitter')->redirect();
    }

    function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver("twitter")->user();
    }
}
