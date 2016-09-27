<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model {

	protected $casts = [
		'show_content' => 'boolean'
	];

	public static $types = [
		'collection slideshow' => 1,
//		'collection grid view' => 2,
		'collection vertical normal' => 2,
//		'collection horizontal normal' => 3,
		'collection hero big' => 3,
		'venue slideshow' => 4,
		'venue hero big' => 5,
		'venue hero normal' => 6,
//		'venue horizontal thumbnail' => 10,
//		'venue vertical thumbnail' => 11,
		'venue vertical normal' => 7,
//		'venue vertical grid view' => 13,
//		'venue horizontal normal ' => 14
	];
	protected $dates = ['starts_at', 'created_at', 'updated_at', 'ends_at'];
	protected $fillable = ['name', 'description', 'ends_at', 'type', 'starts_at', 'city_id', 'active', 'order'];

	public function venues()
	{
		return $this->belongsToMany('App\Venue')->withTimestamps();
	}

	public function photo()
	{
		return $this->morphMany('App\Photo', 'imageable');
	}

	public function scopeAvailableVenues($q, City $city)
	{
		$venueIds = Location::where("city_id", $city->getKey())->select('venue_id')->get()->toArray();

		$q->wherePivot('starts_at', "<=", Carbon::now())
			->wherePivot('ends_at', '>=', Carbon::now())
			->whereIn('venue_id', $venueIds)
			->take(1);
		dd($q->get());
	}

	public function newPivot(Model $parent, array $attributes, $table, $exists)
	{
		if ($parent instanceof Venue) return new CollectionVenuePivot($parent, $attributes, $table, $exists);
		return parent::newPivot($parent, $attributes, $table, $exists);
	}

}
