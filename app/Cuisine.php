<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;

class Cuisine extends Model {
    use Sluggable,SluggableScopeHelpers;

	protected $sluggable = [
		'build_from' => 'name',
		'save_to' => 'slug',
	];
	protected $fillable = ['name', 'display_name'];
	public $timestamps = false;

	public function venues()
	{
		return $this->belongsToMany('App\Venue');
	}

	public function photo()
	{
		return $this->morphMany('App\Photo', 'imageable');
	}

	public function scopeFirstPage($query)
	{
		return $query->where("first_page", 1);
	}

	public function setFirstPageAttribute($value)
	{
		if (is_null($value))
			$this->attributes["first_page"] = 0;
		else if ($value == "on")
			$this->attributes["first_page"] = 1;
	}

	public function topVenues()
	{
		return $this->venues()->where("score", ">=", 3);
	}
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug'=>[
                'source'=>'name',
            ]
        ];
    }
}

