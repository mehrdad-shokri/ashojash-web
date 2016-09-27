<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use Sluggable, SluggableScopeHelpers;
    protected $fillable = ['name', 'display_name'];

    public function takeVenuesByCuisineSlug($cuisineSlug)
    {
        $city = $this;

        $venues = Venue::whereHas('location', function ($query) use ($city)
        {
            $query->whereCityId($city->getKey());
        })
            ->whereHas('cuisines', function ($query) use ($cuisineSlug)
            {
                $query->whereSlug($cuisineSlug);
            });

        return $venues;
    }

    public function takeTopVenuesByCuisineSlug($cuisineSlug)
    {
        $city = $this;
        $venues = Venue::whereHas('location', function ($query) use ($city)
        {
            $query->whereCityId($city->getKey());
        })
            ->whereHas('cuisines', function ($query) use ($cuisineSlug)
            {
                $query->whereSlug($cuisineSlug);
            });

        return $venues;
    }
    public function locations()
    {
        return $this->hasMany('App\Location');
    }


    public function photo()
    {
        return $this->morphMany('App\Photo', 'imageable');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function venues()
    {
        $city = $this;
        $venues = Venue::whereHas('location', function ($query) use ($city) {
            $query->whereCityId($city->id);
        })->get();
        return $venues;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }
}
