<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

	protected $fillable = ['name', 'level'];

	public function venues()
	{
		return $this->belongsToMany('App\Venue')->withPivot(['score']);
	}

	public function photo()
	{
		$this->morphMany("App\Photo", 'imageable');
	}
}
