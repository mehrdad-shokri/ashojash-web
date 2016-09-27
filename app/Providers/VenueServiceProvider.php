<?php

namespace App\Providers;

use App\Location;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class VenueServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Location::creating(function ($eloquentModel) {
            $eloquentModel->setAttribute('geolocation', DB::raw("ST_GeomFromText('POINT(".$this->getPoint($eloquentModel).")')"));
        });

        Location::updated(function ($eloquentModel) {
            $eloquentModel->setAttribute('geolocation', DB::raw("ST_GeomFromText('POINT(" . $this->getPoint($eloquentModel) . ")')"));
        });
    }

    public function getPoint($eloquentModel)
    {
        if (isset($eloquentModel->lat, $eloquentModel->lng)) {
            return $eloquentModel->lat . ' ' . $eloquentModel->lng;
        } else {
            return '0  0';
        }
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
