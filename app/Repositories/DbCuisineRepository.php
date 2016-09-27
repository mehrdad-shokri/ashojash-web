<?php namespace app\Repository;


use App\City;
use App\Cuisine;
use App\Venue;
use Illuminate\Support\Facades\DB;

class DbCuisineRepository implements CuisineRepository {

	public function findById($id)
	{
		return Cuisine::findOrFail($id);
	}

	public function findBySlug($slug)
	{
		return Cuisine::findBySlugOrFail($slug);
	}

	public function create($name)
	{
		return Cuisine::create(['name' => $name]);
	}

	public function destroy($id)
	{
		return Cuisine::destroy($id);
	}


	public function venuesByCuisineSlug(City $city, $slug)
	{

		$venues = Venue::whereHas('location', function ($query) use ($city)
		{
			$query->whereCityId($city->getKey());
		})
			->whereHas('cuisines', function ($query) use ($slug)
			{
				$query->whereSlug($slug);
			});

		return $venues;
	}

	public function simplePaginate($count)
	{
		return DB::table("cuisines")->simplePaginate(10);
	}


}