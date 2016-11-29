<?php

namespace App\Http\Controllers\Api\V2\Mobile;

use App\Api\Transformer\TokenTransformer;
use app\Api\Transformer\UserRegisteredTransformer;
use App\Api\Transformer\UserTransformer;
use App\Http\Controllers\Api\v2\BaseController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GoogleOauthController;
use App\Mail\UserTokenRegistered;
use app\Repository\GoogleOauthRepository;
use app\Repository\UserRepository;
use Google_Auth_Exception;
use Google_Client;
use Google_Service_Oauth2;
use Google_Service_Plus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

class AuthController extends BaseController
{


    protected $userRepository;
    private $apiClient;
    private $googleOauthRepository;

    /**
     * UsersController constructor.
     * @param UserRepository $userRepository
     * @param GoogleOauthRepository $googleOauthRepository
     */
    public function __construct(UserRepository $userRepository, GoogleOauthRepository $googleOauthRepository)
    {
        $this->userRepository = $userRepository;
        $this->apiClient = new Google_Client();
        $this->apiClient->setApplicationName(env("APP_NAME"));
        $this->apiClient->setClientId(env("GOOGLE_KEY"));
        $this->apiClient->setClientSecret(env("GOOGLE_SECRET"));
        $this->apiClient->setScopes(GoogleOauthController::getScopes());
        $this->googleOauthRepository = $googleOauthRepository;
    }

    public function postRegister(Request $request)
    {
        $validator = app('validator')->make($request->all(), RegisterController::$rules);
        if ($validator->fails()) {
            return $this->response->errorBadRequest($this->errorResponse($validator));
        }
        $user = $this->userRepository->create($request->get('name'), $request->get('username'), $request->get('email'), $request->get('password'));
        Mail::to($user->email)->send(new UserTokenRegistered($user));
        return $this->response->item($user, new UserRegisteredTransformer());
    }

    public function postLogin(Request $request)
    {
        $rules = [
            'login' => 'required',
            'password' => 'required',
        ];
        $validator = app('validator')->make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->response->errorBadRequest($this->errorResponse($validator));
        }
        $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input('login')]);
        if (Auth::once([$field => $request->get("login"), "password" => $request->get('password'), "email_token" => null, "ban" => 0], $request->get('remember') == true)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
            return $this->response->item($user, new UserTransformer($token));
        }
        $this->response->errorBadRequest(trans('auth.not_matching'));
    }

    public function handleApiProviderCallback(Request $request)
    {
        $rules = [
            'auth-code' => 'required'
        ];
        $validator = app('validator')->make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->response->errorBadRequest($this->errorResponse($validator));
        }
        try {
            $authCode = $request->get('auth-code');
            $this->apiClient->authenticate($authCode);
            $googleOath2Service = new Google_Service_Oauth2($this->apiClient);
            $googlePlusService = new Google_Service_Plus($this->apiClient);
            $userBasicInfo = $googleOath2Service->userinfo->get();
            $userPlusInfo = $googlePlusService->people->get('me');
            $user = $this->googleOauthRepository->authenticateApi($this->apiClient, $userBasicInfo, $userPlusInfo);
            $token = JWTAuth::fromUser($user);
            return $this->response->item($user, new UserTransformer($token));
        } catch (Google_Auth_Exception $e) {
            return $this->response->errorBadRequest("Validation failed.");
        }
    }

    public function refreshToken(Request $request)
    {
        $rules = [
            'token' => 'required'
        ];
        $validator = app('validator')->make($request->all(), $rules);
        if ($validator->fails() && !$request->header("Authorization")) {
            $this->response->errorBadRequest($this->errorResponse($validator));
        }
        try {
            $token = JWTAuth::getToken();
            $newToken = JWTAuth::refresh($token);
            return $this->response->item(new Token($newToken), new TokenTransformer());
        } catch (TokenExpiredException $e) {
            $this->response->errorBadRequest("The token has been blacklisted.");
        } catch (JWTException $e) {
            $this->response->errorBadRequest("The token is invalid.");
        }
    }
}
