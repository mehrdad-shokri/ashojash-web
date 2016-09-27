<?php

namespace App\Http\Middleware;

use App\Venue;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorizeBusinessOwner {

	/**
	 * @var Guard
	 */
	/**
	 * @var Guard
	 */
	private $auth;

	/**
	 * AuthorizeBusinessOwner constructor.
	 *
	 * @param Guard $auth
	 * @internal param Guard $guard
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
		$venue = Venue::findBySlugOrFail($request->route('venueSlug'));

		if ($this->auth->guest())
		{
			if ($request->ajax())
				return response('Not Found', 404);
			else
			{
				return redirect('');
			}
		}
		else if ($this->auth->user()->hasRole('admin'))
		{
			return $next($request);
		}
		else if ($venue->isValid($this->auth->user()->getKey()))
		{
			return $next($request);
		}
		else
		{
			if ($request->ajax())
				return response('Not found.', 404);
			else
			{
				return redirect('');
			}
		}
	}
}
