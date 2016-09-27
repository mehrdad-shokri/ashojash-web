<?php namespace app\Repository;


use Google_Client;
use Google_Service_Oauth2_Userinfoplus;
use Google_Service_Plus_Person;
use Laravel\Socialite\Two\User;

interface GoogleOauthRepository {


	/*function associateGoogleOauth($token, $name, $email, $lang, $avatar, $url, $social_id, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount, $socialId);*/

	public function authenticateWeb(User $userData);

	public function authenticateApi(Google_Client $apiClient, Google_Service_Oauth2_Userinfoplus $userBasicInfo, Google_Service_Plus_Person $userPlusInfo);
}