<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model {

	protected $fillable = ['name', 'display_name'];

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
		$venues = Venue::whereHas('location', function ($query) use ($city)
		{
			$query->whereCityId($city->id);
		})->get();
		return $venues;
	}
}
