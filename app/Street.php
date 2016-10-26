<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Street extends Model {

	protected $primaryKey = "OGR_FID";
	use Searchable;

	public function toSearchableArray()
	{
		$array = array("name" => $this->name, "name_suggest" => $this->name, $this->getKeyName() => $this->getKey(), 'city_id' => $this->city->getKey());
		return $array;
	}

	public function city()
	{
		return $this->belongsTo("App\City");
	}
}
