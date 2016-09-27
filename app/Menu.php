<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $fillable = ['price', 'menu_item', 'ingredients', 'venue_id'];
	public $timestamps = false;

	public function venue()
	{
		return $this->belongsTo('App\Venue');
	}

}
