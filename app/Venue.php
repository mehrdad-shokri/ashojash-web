<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model{

	use SluggableTrait;
	protected $sluggable = [
		'build_from' => 'name',
		'save_to' => 'slug',
	];
	use SearchableTrait;
	protected $searchable = [
		'columns' => [
			'venues.name' => 10,
			'locations.address' => 10,
			'cuisines.name' => 10
		],
		'joins' => [
			'locations' => ['venues.id', 'locations.venue_id'],
			'cuisine_venue' => ['venues.id', 'cuisine_venue.venue_id'],
			'cuisines' => ['cuisines.id', 'cuisine_venue.cuisine_id']
		]
	];


	public $dates = ['valid_until', 'starts_at'];
	protected $fillable = ['name', 'details', 'phone', 'mobile', 'url', 'instagram', 'status'];

	private $minReview = 5;

	protected static $allowUnapprovedVenues = false;

	public function newQuery()
	{
		$query = parent::newQuery();
		if (!static::$allowUnapprovedVenues)
		{
			$query->where('status', '=', 1);
		}
		else
		{
			static::$allowUnapprovedVenues = false;
		}
		return $query;
	}

	// call this if you need unapproved posts as well
	public static function allowUnapprovedPosts()
	{
		static::$allowUnapprovedVenues = true;
		return new static;
	}

	public function vendor()
	{
		return $this->belongsTo('App\Vendor');
	}

	public function location()
	{
		return $this->hasOne('App\Location');
	}


	public function photos()
	{
		return $this->morphMany('App\Photo', 'imageable');
	}

	public function mainPhoto()
	{
		return $this->morphMany("App\Photo", 'imageable');
	}

	public function city()
	{
		return $this->location->city;
	}

	public function scopePending($query)
	{
		return $query->where('status', '0');
	}

	public function cuisines()
	{
		return $this->belongsToMany('App\Cuisine');
	}

	public function payments()
	{
		return $this->hasMany("App\Payment");
	}


	public function tags()
	{
		return $this->belongsToMany('App\Tag');
	}

	public function hasImgId()
	{
		return !($this->image_id === null);
	}

	public function setImgId($id)
	{
		$this->image_id = $id;
		$this->touch();
		$this->save();
	}

	public function getImgId()
	{
		return $this->image_id;
	}

	public function reviews()
	{
		return $this->hasMany('App\Review');
	}


	public function calcWR()
	{
		$minReview = $this->minReview;
		$reviewCount = $this->reviews()->count();
		if ($reviewCount < $minReview)
			return 0;
		$qualitySum = $this->reviews()->sum('quality');
		$decorSum = $this->reviews()->sum('decor');
		$venueSum = $qualitySum * 2 + $decorSum;
		$venueAverage = $venueSum / (3 * $reviewCount);
		$average = ($reviewCount * $venueAverage) / ($reviewCount + $minReview) + ($minReview * Review::C()) / ($reviewCount + $minReview);
		$this->score = $average;
		$this->save();
	}

	public function calcCost()
	{
		$costSum = $this->reviews()->sum('cost');
		$count = $this->reviews()->count();
		if ($count < 5)
			return 0;
		$this->cost = $costSum / $count;
		$this->save();
	}

	public function owner()
	{
		return $this->belongsTo('App\User', 'owner_id');
	}

	public function schedules()
	{
		return $this->hasMany('App\Schedule');
	}

	public function menus()
	{
		return $this->hasMany('App\Menu');
	}

	public function isValid($userId)
	{
		return ($this->valid_until >= Carbon::now()) && ($this->owner_id == $userId);
	}


	public function hasMainImg()
	{
		return !is_null(Venue::where('id', $this->getKey())->first()->image_id);
	}

	public function assignUserByid($id)
	{
		$this->owner_id = $id;
		$this->save();
	}


	public function collections()
	{
		return $this->belongsToMany("App\Venue")->withTimestamps();
	}
	public function newPivot(Model $parent, array $attributes, $table, $exists)
	{
		if ($parent instanceof Collection) return new CollectionVenuePivot($parent, $attributes, $table, $exists);
		return parent::newPivot($parent, $attributes, $table, $exists);
	}
}
