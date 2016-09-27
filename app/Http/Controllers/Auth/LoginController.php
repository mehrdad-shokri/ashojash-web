<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use app\Repository\UserRepository;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->repository = $repository;
    }

    public function login(LoginRequest $request)
    {
        $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input('login')]);

        if (Auth::attempt([$field => $request->get("login"), "password" => $request->get('password'), "email_token" => null, "ban" => 0], $request->get('remember') == true)) {
            return redirect('/');
        }

        return redirect('auth/login')->withErrors([
            'error' => trans("auth.not_matching"),
        ]);
    }

    public function confirmEmail($emailToken)
    {
        $this->repository->confirmEmailToken($emailToken);
        flash()->overlay(trans("modals.finish"), trans("modals.email_confirmed"));
        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
