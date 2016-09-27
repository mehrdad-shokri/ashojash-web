<?php namespace app\Repository;


use App\GoogleOauth;
use App\User;
use Google_Client;
use Google_Service_Oauth2_Userinfoplus;
use Google_Service_Plus_Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class DbGoogleOauthRepository implements GoogleOauthRepository {


	private $user;
	private $isNewUser;
	private $userRepository;

	private $authUser;

	/**
	 * DbGoogleOauthRepository constructor.
	 * @param UserRepository $userRepository
	 * @internal param $user
	 */
	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * @param \Laravel\Socialite\Two\User $userData
	 * @return mixed
	 */
	public function authenticateWeb(\Laravel\Socialite\Two\User $userData)
	{

		$token = $userData->token;
		$name = $userData->name;
		$email = $userData->getEmail();
		$lang = $userData->user['language'];
		$avatar = $userData->avatar;
		$url = $userData->user['url'];
		$socialId = $userData->id;
		$verified = $userData->user['verified'];
		$isPlusUser = $userData->user['isPlusUser'];
		$minRange = $userData->user['ageRange']['min'];
		$maxRange = $userData->user['ageRange']['max'];
		$etag = $userData->user['etag'];
		$circledByCount = $userData->user['circledByCount'];


		$this->retrieveAuthenticatedUserIfPresent(false);

		$user = $this->syncUser($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount);
		if ($this->isNewUser)
			flash()->overlay(trans("modals.finish"), trans("modals.signup_completed"));

		return $user;
	}

	public function authenticateApi(Google_Client $apiClient, Google_Service_Oauth2_Userinfoplus $userBasicInfo, Google_Service_Plus_Person $userPlusInfo)
	{
		$token = json_decode($apiClient->getAccessToken())->access_token;
		$name = $userBasicInfo->getName();
		$email = $userBasicInfo->getEmail();
		$lang = $userPlusInfo->getLanguage();
		$avatar = $userPlusInfo->getImage()->url;
		$url = $userPlusInfo->getUrl();
		$socialId = $userBasicInfo->getId();
		$verified = $userPlusInfo->verified;
		$isPlusUser = $userPlusInfo->getIsPlusUser();
		$minRange = $userPlusInfo->getAgeRange()->min;
		$maxRange = $userPlusInfo->getAgeRange()->max;
		$etag = $userPlusInfo->getEtag();
		$circledByCount = $userPlusInfo->getCircledByCount();

		$this->retrieveAuthenticatedUserIfPresent(true);

		$user = $this->syncUser($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount);

		if ($this->isNewUser)
			session()->flash("api_flash_message", true);
//			apiFlash()->overlay(trans("modals.finish"), trans("modals.signup_completed"));
		return $user;
	}

	private function syncUser($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount)
	{
		$baseUser = User::where("email", $email)->first();
		$googleOauth = GoogleOauth::where("email", $email)->first();
		$this->isNewUser = false;

		if (!is_null($googleOauth) && !is_null($this->authUser))    //user is logged in and associated his account
		{
			$this->user = $googleOauth->user;
			$this->updateGoogleOauth($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount);

			return $this->authUser;
		}
		else if (!is_null($googleOauth) && is_null($this->authUser)) // user has associated his account and is not logged in
		{
			$this->user = $googleOauth->user;
			$this->updateGoogleOauth($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount);
			Auth::login($googleOauth->user);

			return $googleOauth->user;
		}
		else if (!is_null($baseUser) && is_null($googleOauth) && !is_null($this->authUser))    // user has registered with this email, is logged in, has NOT associated his account
		{
			Log::info("here in fuck condition");
			$this->user = $baseUser;
			$this->associateGoogleOauth($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount);

			return $baseUser;
		}
		else if (!is_null($baseUser) && is_null($googleOauth) && is_null($this->authUser))    // user is NOT logged in, has NOT associated his account, has registered with this email
		{
			$this->user = $baseUser;
			$this->associateGoogleOauth($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount);
			Auth::login($baseUser);

			return $baseUser;
		}
		else if (is_null($baseUser) && is_null($googleOauth) && !is_null($this->authUser))    // user has NOT registered with this email, has NOT associated his account, is logged in
		{
			$this->user = $this->authUser;
			$this->associateGoogleOauth($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount);

			return $this->authUser;
		}
		else if (is_null($baseUser) && is_null($googleOauth) && is_null($this->authUser))    // user has NOT account, has not associated his account, is NOT logged in
		{
			$user = $this->userRepository->create(self::slugify($name), $name, $email, bcrypt('password' . time()));
			$user->save();
			$user->email_token = null;
			$this->user = $user;
			$this->associateGoogleOauth($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount);
			$this->isNewUser = true;
			Auth::login($user);
			return $user;
		}
	}


	private function associateGoogleOauth($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount)
	{
		$googleOauth = $this->user->googleOauth()->create(
			[
				'token' => $token,
				'name' => $name,
				'email' => $email,
				'lang' => $lang,
				'avatar' => $avatar,
				'url' => $url,
				'social_id' => $socialId,
				'verified' => $verified,
				'is_plus_user' => $isPlusUser,
				'min_range' => $minRange,
				'max_range' => $maxRange,
				'etag' => $etag,
				'circled_by_count' => $circledByCount
			]
		);
		$googleOauth->save();

		return $googleOauth;
	}

	private function updateGoogleOauth($token, $name, $email, $lang, $avatar, $url, $socialId, $verified, $isPlusUser, $minRange, $maxRange, $etag, $circledByCount)
	{
		$googleOauth = $this->user->googleOauth()->update([
			'token' => $token,
			'name' => $name,
			'email' => $email,
			'lang' => $lang,
			'avatar' => $avatar,
			'url' => $url,
			'social_id' => $socialId,
			'verified' => $verified,
			'is_plus_user' => $isPlusUser,
			'min_range' => $minRange,
			'max_range' => $maxRange,
			'etag' => $etag,
			'circled_by_count' => $circledByCount
		]);

		return $googleOauth;

	}


	public static function slugify($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// lowercase
		$text = strtolower($text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text))
		{
			return 'user-' . time();
		}

		return $text;
	}

	private function retrieveAuthenticatedUserIfPresent($isApi = true)
	{
		if ($isApi)
		{
			try
			{

				if (!$user = JWTAuth::parseToken()->authenticate())
				{
					return response()->json(['user_not_found'], 404);
				}
			} catch (TokenExpiredException $e)
			{
				return response()->json(['token_expired'], $e->getStatusCode());
			} catch (TokenInvalidException $e)
			{
				return response()->json(['token_invalid'], $e->getStatusCode());
			} catch (JWTException $e)
			{
//			token not issued
				return null;
			}
			$this->authUser = $user;
		}
		else
		{
			$this->authUser = Auth::user();
		}
	}


}