<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function venues()
    {
        return $this->belongsToMany('App\Venue');
    }
}
