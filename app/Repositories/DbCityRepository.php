<?php namespace app\Repository;


use App\City;

class DbCityRepository implements CityRepository {

	public function findById($userId)
	{
		return City::findOrFail($userId);
	}

	public function findBySlugOrFail($slug)
	{
		return City::findBySlugOrFail($slug);
	}

	public function available($limit=20)
	{
		return City::where('status', 1)->take($limit);
	}

	public function all($with = null)
	{
		if (!is_null($with))
			return City::with($with);

		return City::all();
	}


}