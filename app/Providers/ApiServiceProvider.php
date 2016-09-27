<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Api\NoDataArraySerializer;
use Dingo;
use League\Fractal\Manager;
class ApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
	{
		app('Dingo\Api\Auth\Auth')->extend('jwt', function ($app)
		{
			return new Dingo\Api\Auth\Provider\JWT($app['Tymon\JWTAuth\JWTAuth']);
		});

		app('Dingo\Api\Transformer\Factory')->setAdapter(function ($app)
		{
			$fractal = new Manager;
			$fractal->setSerializer(new NoDataArraySerializer());
			return new Dingo\Api\Transformer\Adapter\Fractal($fractal);
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
