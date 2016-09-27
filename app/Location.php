<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {

	protected $fillable = ['address', 'neighbor_id', 'city_id', 'country_id', 'lat', 'lng'];

	public function newQuery()
	{
		$query = parent::newQuery();
		$query->whereHas('venue', function ($q)
		{
			$q->where('status', '=', 1);
		});
		return $query;
	}

	public function city()
	{
		return $this->belongsTo('App\City');
	}
	public function country (){
        return $this->belongsTo('App\Country');
	}

	public function neighbor()
	{
		return $this->belongsTo('App\Neighbor');
	}

	public function venue()
	{
		return $this->belongsTo('App\Venue');
	}
}
