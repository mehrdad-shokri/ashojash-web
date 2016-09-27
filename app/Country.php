<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
use Sluggable;
    protected $fillable = ['name'];
    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    public function venues()
    {
        return $this->hasManyThrough('App\Venue', 'App\Location', 'country_id', 'venue_id');
    }
/**
* Return the sluggable configuration array for this model.
*
* @return array
*/
    public function sluggable()
    {
        return [
            'slug'=>[
                'source'=>'name',
            ]
        ];
    }
}
