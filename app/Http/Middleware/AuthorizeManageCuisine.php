<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;

class AuthorizeManageCuisine{

	private $PERMISSION_NAME = 'manage-cuisine';

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
		if ($this->auth->guest())
		{
			if ($request->ajax())
				return response('Unauthorized', 403);
			else
			{
				abort(403);
			}
		}
		if ($this->auth->user()->can($this->PERMISSION_NAME))
		{
			return $next($request);
		}
		else
		{
			if ($request->ajax())
				return response('Unauthorized', 403);
			else
			{
				abort(404);
			}
		}
	}
}
