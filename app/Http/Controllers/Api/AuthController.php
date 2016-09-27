<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\GoogleOauthController;
use App\Http\Requests;
use App\Mailers\UserMailer;
use app\Repository\GoogleOauthRepository;
use app\Repository\UserRepository;
use app\Transformers\UserTransformer;
use Google_Auth_Exception;
use Google_Client;
use Google_Service_Oauth2;
use Google_Service_Plus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends ApiController {

	protected $userRepository;
	private $userTransformer;
	private $apiClient;
	private $googleOauthRepository;
	/**
	 * @var UserMailer
	 */
	private $userMailer;

	/**
	 * UsersController constructor.
	 * @param UserRepository $userRepository
	 * @param UserTransformer $userTransformer
	 * @param GoogleOauthRepository $googleOauthRepository
	 * @param UserMailer $userMailer
	 */
	public function __construct(UserRepository $userRepository, UserTransformer $userTransformer, GoogleOauthRepository $googleOauthRepository, UserMailer $userMailer)
	{
		$this->userRepository = $userRepository;
		$this->userTransformer = $userTransformer;
		$this->apiClient = new Google_Client();
		$this->apiClient->setApplicationName(env("APP_NAME"));
		$this->apiClient->setClientId(env("GOOGLE_KEY"));
		$this->apiClient->setClientSecret(env("GOOGLE_SECRET"));
		$this->apiClient->setScopes(GoogleOauthController::getScopes());
		$this->googleOauthRepository = $googleOauthRepository;
		$this->userMailer = $userMailer;
	}

	public function postRegister(Request $request)
	{

		$validator = $this->validator($request->all());
		if ($validator->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validator->errors());
		}
		$user = $this->userRepository->create($request->get('username'), $request->get('name'), $request->get('email'), $request->get('password'));
		$this->userMailer->confirm($user);
		$data = array();
//			$data['user'] = $this->userTransformer->transform($user);
		$data['email_sent'] = true;
		$data['is_google_user'] = $this->isUserGmailUser($user->email);

		return $this->setStatusCode(200)->response(['data' => $data,]);
	}

	public function postLogin(Request $request)
	{
		$validation = Validator::make($request->all(), [
			'login' => 'required',
			'password' => 'required'
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validation->errors());
		}
		$field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
		$request->merge([$field => $request->input('login')]);
		if (Auth::once([$field => $request->get("login"), "password" => $request->get('password'), "email_token" => null, "ban" => 0], $request->get('remember') == true))
		{
			$user = Auth::user();
//				create token for the user along with some data
			$userArray = $this->userTransformer->transform($user);
			$token = JWTAuth::fromUser($user);
			$data = array();
			$data['user'] = $userArray;
			$data['token_payload'] = $this->getToken($token);
			return $this->response(['data' => $data]);
		}
		return $this->setStatusCode(400)->respondWithError(trans('auth.not_matching'));
	}


	/**
	 * refreshes token via middelware
	 */
	public function refreshToken()
	{
		try
		{
			$token = JWTAuth::getToken();
			$newToken = JWTAuth::refresh($token);
			$data = array();
			$data['token_payload'] = $this->getToken($newToken);
			return $this->response(['data' => $data]);
		} catch (TokenExpiredException $e)
		{
			return $this->setStatusCode(400)->response([
				'error' => [
					'message' => 'token_expired',
					'code' => 400
				]
			]);
		} catch (JWTException $e)
		{

			return $this->setStatusCode(400)->response([
				'error' => [
					'message' => 'token_invalid',
					'code' => 400
				]
			]);
		}
	}

	public function handleApiProviderCallback(Request $request)
	{
		Log::info("handleApiProviderCallback");
		$validation = Validator::make($request->all(), [
			'auth-code' => 'required',
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError('authentication code missing');
		}
		try
		{

			$authCode = $request->get('auth-code');
			Log::info("got auth code");
			$this->apiClient->authenticate($authCode);
			Log::info("authenticated");
			$googleOath2Service = new Google_Service_Oauth2($this->apiClient);
			$googlePlusService = new Google_Service_Plus($this->apiClient);
			Log::info("getting user basic info");
			$userBasicInfo = $googleOath2Service->userinfo->get();
			Log::info("getting plus info");
			$userPlusInfo = $googlePlusService->people->get('me');
			Log::info("creating user");
			$user = $this->googleOauthRepository->authenticateApi($this->apiClient, $userBasicInfo, $userPlusInfo);


			$token = JWTAuth::fromUser($user);
			$userArray = $this->userTransformer->transform($user->toArray());
			$data = array();
			$data['user'] = $userArray;
			$data['token_payload'] = $this->getToken($token);

			if (session()->has('api_flash_message'))
			{
				$data['is_new_user'] = true;

				return $this->setStatusCode(200)->response(['data' => $data]);
			}
			else
			{
				$data['is_new_user'] = false;

				return $this->setStatusCode(200)->response(['data' => $data]);
			}
		} catch (Google_Auth_Exception $e)
		{
			return $this->setStatusCode(500)->respondWithError('validation failed');

		}
	}

	/*public function handleApiProviderCallback2()
	{
		$user = Auth::loginUsingId(456);
		$token = JWTAuth::fromUser($user);
		$userArray = $this->userTransformer->transform($user->toArray());
		$data['exp'] = JWTAuth::getPayload($token)['isa'];

		$data = array();
		$data['user'] = $userArray;
		$data['token'] = $token;
		$data['exp'] = $this->getTokenExpiration($token);

		return $this->setStatusCode(200)->response(['data' => $data]);
	}*/

	protected function validator(array $data)
	{

		return Validator::make($data, [
			'name' => 'required|max:255|min:4|regex:/^[\x{0600}-\x{06FF}\x{FB8A}\x{067E}\x{0686}\x{06AF} ]+$/u',
			'username' => 'required|max:255|unique:users|min:4|regex:/^[a-zA-Z0-9-]*$/',
			'email' => 'required|email|max:255|unique:users|unique:google_oauth',
			'password' => 'required|min:6|max:255',
		]);
	}

	private function isUserGmailUser($email)
	{
		$domain = explode('@', strtolower($email));
		return ($domain == "gmail.com") || $domain == "googlemail.com";
	}

	/**
	 * @param $token
	 * @return array
	 */
	public function getToken($token)
	{
		JWTAuth::setToken($token);
		$data = array();
		$data['token'] = $token;
		$data['ttl_refresh'] = config("jwt.refresh_ttl");
		$data['ttl'] = config("jwt.ttl");
		$data['exp'] = JWTAuth::getPayload()['exp'];
		return $data;
	}

}