<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Tag extends Model {

	use SearchableTrait;
	protected $searchable = [
		'columns' => [
			'tags.name' => 1,
		]
	];
	protected $fillable = ['name', 'level'];

	public function venues()
	{
		return $this->belongsToMany('App\Venue')->withPivot(['weight']);
	}

	public function photo()
	{
		return $this->morphMany('App\Photo', 'imageable');
	}
}
