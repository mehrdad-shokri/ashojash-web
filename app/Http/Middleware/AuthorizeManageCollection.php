<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthorizeManageCollection {

	private $PERMISSION_NAME = 'manage-collection';

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
