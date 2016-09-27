<?php

	namespace App\Http\Controllers;

	use App\GoogleOauth;
	use App\Http\Requests;
	use app\Repository\GoogleOauthRepository;
	use App\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Laravel\Socialite\Facades\Socialite;

	class GoogleOauthController extends Controller implements OAuth {


		/**
		 * @var GoogleOauthRepository
		 */
		private $googleOauthRepository;


		/**
		 * GoogleOauthController constructor.
		 * @param GoogleOauthRepository $googleOauthRepository
		 */
		public function __construct(GoogleOauthRepository $googleOauthRepository)
		{
			$this->googleOauthRepository = $googleOauthRepository;
		}


		function redirectProvider()
		{
			return Socialite::with('google')->scopes(self::getScopes())->redirect();
		}

		function handleProviderCallback(Request $request)
		{
			$userData = Socialite::with("google")->user();
			$this->googleOauthRepository->authenticateWeb($userData);
			return redirect()->action("PagesController@home");
		}


		/*public function signOrLogin($userData, $email)
		{
			$previousUser = User::where("email", $email)->first();
			$oauthUser = GoogleOauth::where("email", $email)->first();
			$currentUser = Auth::user();
			if (!is_null($oauthUser) && !is_null($currentUser))    //user is logged in and associated his account
			{
				return Auth::user();
			}
			else if (!is_null($oauthUser) && is_null($currentUser)) // user has associated his account and is not logged in
			{
				Auth::login($oauthUser->user);

				return Auth::user();
			}
			else if (!is_null($previousUser) && is_null($oauthUser) && !is_null($currentUser))    // user has registered with this email, is logged in, has NOT associated his account
			{

				$googleOauth = $currentUser->associateGoogleOauth($userData);

				return Auth::user();
			}
			else if (!is_null($previousUser) && is_null($oauthUser) && is_null($currentUser))    // user is NOT logged in, has NOT associated his account, has registered with this email
			{
				$googleOauth = $previousUser->associateGoogleOauth($userData);
				Auth::login($previousUser);

				return Auth::user();
			}
			else if (is_null($previousUser) && is_null($oauthUser) && !is_null($currentUser))    // user has NOT registered with this email, has NOT associated his account, is logged in
			{
				$googleOauth = $currentUser->associateGoogleOauth($userData);

				return Auth::user();
			}
			else if (is_null($previousUser) && is_null($oauthUser) && is_null($currentUser))    // user has NOT account, has not associated his account, is NOT logged in
			{
				$user = User::create(['username' => self::slugify($userData->name), 'name' => $userData->name, 'email' => $userData->getEmail()]);
				$user->email_token = null;
				$user->save();
				$googleUser = $user->associateGoogleOauth($userData);
				flash()->overlay(trans("modals.finish"), trans("modals.signup_completed"));

				Auth::login($user);

				return $user;
			}
		}*/


		/**
		 * @return array
		 */
		public static function getScopes()
		{
			return ['https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile', 'https://www.googleapis.com/auth/plus.login'];
		}
	}