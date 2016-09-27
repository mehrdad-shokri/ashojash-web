<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserTokenRegistered;
use app\Repository\UserRepository;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * Create a new controller instance.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware('guest');
        $this->repository = $repository;
    }

    public static $rules = [
        'name' => 'required|max:255|min:4|regex:/^[\x{0600}-\x{06FF}\x{FB8A}\x{067E}\x{0686}\x{06AF} ]+$/u',
        'username' => 'required|max:255|unique:users|min:4|regex:/^[a-zA-Z0-9-]*$/',
        'email' => 'required|email|max:255|unique:users|unique:google_oauth',
        'password' => 'required|min:6|max:255',
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator(array $data)
    {
        return Validator::make($data, RegisterController::$rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return $this->repository->create($data['username'], $data['name'], $data['email'], $data['password']);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        Mail::to($user->email)->send(new UserTokenRegistered($user));
        flash()->overlay(trans('modals.finish'), trans('modals.email_confirmation'));
        return redirect($this->redirectPath());
    }
}
