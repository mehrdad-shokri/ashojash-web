<?php

namespace App\Providers;

use Dingo\Api\Contract\Debug\ExceptionHandler;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;
use App\Api\NoDataArraySerializer;
use Dingo;
use Intervention\Image\Exception\NotFoundException;
use League\Fractal\Manager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 *
	 * @param ExceptionHandler $handler
	 */
    public function boot(ExceptionHandler $handler)
	{
		app('Dingo\Api\Auth\Auth')->extend('jwt', function ($app)
		{
			return new Dingo\Api\Auth\Provider\JWT($app['Tymon\JWTAuth\JWTAuth']);
		});
		$handler->register(function(ModelNotFoundException $e){
			throw new NotFoundHttpException("Not found.");
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
