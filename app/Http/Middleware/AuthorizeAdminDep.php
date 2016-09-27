<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;

class AuthorizeAdminDep {

	/**
	 * @var Guard
	 */
	private $auth;

	function __construct(Guard $auth)
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
				return response('Not found.', 404);
			else
			{
				abort(404);
			}
		}
		if ($this->auth->user()->hasRole('admin')) {
			return $next($request);
		}
		else
		{
			if ($request->ajax())
				return response('Not found.', 404);
			else
			{
				abort(404);
			}
		}
	}
}
