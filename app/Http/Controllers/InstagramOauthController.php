<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    use App\Http\Requests;
    use App\Http\Controllers\Controller;
    use Laravel\Socialite\Facades\Socialite;

    class InstagramOauthController extends Controller implements OAuth
    {
        function redirectProvider()
        {
            return Socialite::with('instagram')->scopes(['basic', 'likes'])->redirect();
        }

        function handleProviderCallback(Request $request)
        {
            $user = Socialite::driver("instagram")->user();
        }
    }
