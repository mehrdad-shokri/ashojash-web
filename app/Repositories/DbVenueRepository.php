<?php namespace app\Repository;


use App\City;
use App\Location;
use App\Venue;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use stdClass;

class DbVenueRepository implements VenueRepository {

	private $with = [];

	public function all($with = null)
	{
		if (!is_null($with))
			return Venue::with($with);

		return Venue::all();
	}

	public function findById($id)
	{
		return Venue::findOrFail($id);
	}


	public function findBySlugOrFail($slug)
	{
		return Venue::where('slug', $slug)->with($this->getWith())->firstOrFail();

	}

	public function create($name, $phone, $status = 0)
	{
		return Venue::create(['name' => $name, 'phone' => $phone, 'status' => $status]);
	}

	public function whereCity($slug, City $city)
	{
		return Venue::where('slug', $slug)->whereHas('location', function ($query) use ($city)
		{
			$query->whereCityId($city->getKey());
		})->firstOrFail();
	}


	public function currentDaySchedule(Venue $venue)
	{
		return $venue->schedules()->today()->orderBy('opening_at')->get();
	}

	public function schedules(Venue $venue)
	{
		return $venue->schedules;
	}

	public function update(Venue $venue, $name = null, $address = null, $phone = null, $instagram = null, $url = null)
	{
		if (!is_null($name)) $venue->name = $name;
		if (!is_null($address)) $venue->location->address = $address;
		if (!is_null($phone)) $venue->phone = $phone;
		if (!is_null($url)) $venue->url = $url;
		if (!is_null($instagram)) $venue->instagram = $instagram;
		$venue->save();
		$venue->location->save();
	}

	public function top(City $city, $scoreGreaterEqual = 3, $count = 3)
	{
		$cityVenues = Venue::whereHas('location', function ($query) use ($city)
		{
			$query->whereCityId($city->getKey());
		});
		$venues = $cityVenues->top($scoreGreaterEqual)->with("location")->take($count)->orderBy('score', 'des')->get();
		if ($venues->count() < 3)
		{
			return $this->takeRandomVenues($city);
		}
		return $venues;
	}

	public function cityVenues(City $city)
	{
		return Venue::whereHas('location', function ($query) use ($city)
		{
			$query->whereCityId($city->getKey());
		})->get();
	}

	/**
	 * @return array
	 */
	public function getWith()
	{
		$temp = $this->with;
		$this->setWith([]);

		return $temp;
	}

	/**
	 * @param array $with
	 * @return $this
	 */
	public function setWith($with)
	{
		$this->with = $with;

		return $this;
	}

	/**
	 * @param $userLat
	 * @param $userLng
	 * @param float|int $distance in KM
	 * @param int $limit
	 * @return mixed nearby venues
	 */
	public function nearby($userLat, $userLng, $distance = 3, $limit = 30)
	{
//		MAX search distance is 6KM
		if ($distance > 6 || is_null($distance)) $distance = 3;
		if ($limit > 40 || is_null($limit)) $limit = 30;
		$venueIds = DB::table('locations')
			->select(array('lat', 'lng', 'id'))
			->from('locations')
			->havingRaw("lat BETWEEN $userLat - ($distance / 111.045) AND $userLat + ($distance/111.045)")
			->havingRaw("lng BETWEEN $userLng - ($distance / (111.045 * COS(RADIANS($userLat)))) AND $userLng + ($distance / (111.045 * COS(RADIANS($userLat))))")
			->lists('id');
		$locations = Location::select(DB::raw("* , 111.045* DEGREES(ACOS(COS(RADIANS($userLat))
                 * COS(RADIANS(lat))
                 * COS(RADIANS($userLng) - RADIANS(lng))
                 + SIN(RADIANS($userLat))
                 * SIN(RADIANS(lat)))) AS distance"))
			->whereIn("id", $venueIds)
			->havingRaw('distance <' . $distance)
			->orderBy('distance')
			->take($limit)
			->get();
		$venues = collect();
		foreach ($locations as $location)
		{
			$venue = $location->venue;
			$venue->location = $location;
			$venues->push($venue);
		}
		return $venues;
	}

	private function takeRandomVenues(City $city)
	{
		$cityVenues = Venue::whereHas('location', function ($query) use ($city)
		{
			$query->whereCityId($city->getKey());
		});
		$venues = $cityVenues->with($this->getWith())->orderByRaw("RAND()")->take(3)->get();
		return $venues;
	}

	/**
	 * @param $query
	 * @param City $city
	 * @param int $limit
	 * @return mixed
	 * @deprecated
	 */
	public function search($query, City $city, $limit = 20)
	{
		$wordCount = str_word_count($query);
		$relevance = 7.5;
		$searchWholeWord = false;
		if ($wordCount >= 3)
		{
			$relevance = 15;
			$searchWholeWord = true;
		}

		$result = Venue::search($query, $relevance, $searchWholeWord)->with('location')->whereHas('location', function ($query) use ($city)
		{
			$query->whereCityId($city->getKey());
		})->where('status', 1)->take($limit)->orderBy('relevance', 'desc')->get();
		return $result;
	}

	/**
	 * @param $query
	 * @param City $city
	 * @param int $perPage
	 * @return mixed
	 */
	public function searchPaginated($query, City $city, $perPage = 4)
	{
		return $this->paginateCollection($this->search($query, $city, 100), $perPage);
	}

	/**
	 * Paginate the given collection.
	 *
	 * @param \Illuminate\Support\Collection $collection
	 * @param int $perPage
	 * @param string $pageName
	 * @param int|null $page
	 *
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	private function paginateCollection($collection, $perPage = 15, $pageName = 'page', $page = null)
	{
		$page = $page ?: Paginator::resolveCurrentPage($pageName);
		$page = (int) max(1, $page); // Handle pageResolver returning null and negative values
		$path = Paginator::resolveCurrentPath();

		return new LengthAwarePaginator(
			$collection->forPage($page, $perPage),
			count($collection),
			$perPage,
			$page,
			compact('path', 'pageName')
		);
	}

	public function venueReviewsCount(Venue $venue)
	{
		return $venue->reviews()->count();
	}

	public function venueMenusCount(Venue $venue)
	{
		return $venue->menus()->count();
	}

	public function venuePhotosCount(Venue $venue)
	{
		return $venue->photos()->count();
	}

}