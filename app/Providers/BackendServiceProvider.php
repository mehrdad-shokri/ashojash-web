<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->bind('app\Repository\UserRepository', 'app\Repository\DbUserRepository');
		$this->app->bind('app\Repository\GoogleOauthRepository', 'app\Repository\DbGoogleOauthRepository');
		$this->app->bind('app\Repository\CityRepository', 'app\Repository\DbCityRepository');
		$this->app->bind('app\Repository\VenueRepository', 'app\Repository\DbVenueRepository');
		$this->app->bind('app\Repository\ReviewRepository', 'app\Repository\DbReviewRepository');
		$this->app->bind('app\Repository\CountryRepository', 'app\Repository\DbCountryRepository');
		$this->app->bind('app\Repository\CuisineRepository', 'app\Repository\DbCuisineRepository');
		$this->app->bind('app\Repository\LocationRepository', 'app\Repository\DbLocationRepository');
		$this->app->bind('app\Repository\PhotoRepository', 'app\Repository\DbPhotoRepository');
		$this->app->bind('app\Repository\MenuRepository', 'app\Repository\DbMenuRepository');
		$this->app->bind('app\Repository\PaymentRepository', 'app\Repository\ZarinpalPaymentRepository');
		$this->app->bind('app\Repository\PaymentProviderRepository', 'app\Repository\ZarinpalPaymentProviderRepository');
		$this->app->bind('app\Repository\CollectionRepository', 'app\Repository\DbCollectionRepository');
    }
}
