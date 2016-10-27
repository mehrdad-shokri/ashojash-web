<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tag extends Model {

	use Searchable;
	protected $fillable = ['name', 'level'];

	public function venues()
	{
		return $this->belongsToMany('App\Venue')->withPivot(['weight'])->withTimestamps();
	}

	public function photo()
	{
		return $this->morphMany('App\Photo', 'imageable');
	}

	public function toSearchableArray()
	{
		$array = array('name' => $this->name, 'name_suggest' => $this->name, 'id' => $this->getKey());
		return $array;
	}
}
