<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model implements SluggableInterface
{
	use SluggableTrait;
	protected $sluggable = [
		'build_from' => 'name',
		'save_to' => 'slug'
	];
	protected $fillable = [
		'name'
	];

	public function venues()
	{
		return $this->hasMany('App\Venue');
	}

}
