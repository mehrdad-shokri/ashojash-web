<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;

class UserRegisteredProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		User::created(function ($user)
		{
			$user->email_token = str_random(30);
			$user->save();

			return true;
		});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
