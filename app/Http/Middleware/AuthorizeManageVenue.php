<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class AuthorizeManageVenue{

	private $PERMISSION_NAME = 'manage-venue';

	/**
	 * @var Guard
	 */
	private $auth;

	/**
	 * AuthorizeContentProvider constructor.
	 * @param Guard $auth
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = Auth::user();
		if (!is_null($user))
		{
			$canSeePanel = $user->can($this->PERMISSION_NAME);
			if ($canSeePanel)
				return $next($request);
		}
		return response('Bad request', 400);
	}
}
