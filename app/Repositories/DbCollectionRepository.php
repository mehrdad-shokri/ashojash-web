<?php

namespace app\Repository;

use App\City;
use App\Collection;
use App\Location;
use App\Venue;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DbCollectionRepository implements CollectionRepository {

	public function create($name, $description = null, $type, $cityId, $active, $startsAt, $endsAt)
	{
		return Collection::create([
			'name' => $name,
			'description' => $description,
			'type' => $type,
			'city_id' => $cityId,
			'active' => $active,
			'starts_at' => $startsAt,
			'ends_at' => $endsAt]);
	}

	public function cityCollections(City $city)
	{
		$collections = Collection::where('active', 1)->where('starts_at', '<=', Carbon::now())->where(function ($query) use ($city)
		{
			return $query->where("city_id", $city->getKey())->orWhere('city_id', null);
		})->with(['venues' => function ($q) use ($city)
		{
			$venueIds = Location::where("city_id", $city->getKey())->select('venue_id')->get()->toArray();
			$q->wherePivot('starts_at', '<=', Carbon::now()->toDateString())
				->wherePivot('ends_at', '>=', Carbon::now()->toDateString())
				->whereIn('venue_id', $venueIds);
		}])->orderBy('city_id', 'desc')->get();
		$filledCollections = $collections->filter(function ($collection)
		{
			return ($collection->venues->count() > 0);
		});
		return $filledCollections;
	}

	public function venues(Collection $collection, City $city, $take = null)
	{
		$venueIds = Location::where("city_id", $city->getKey())->select('venue_id')->get()->toArray();
		return $collection->belongsToMany('App\Venue')
			->whereIn('venue_id', $venueIds)
			->wherePivot('starts_at', '<=', Carbon::now()->toDateString())
			->wherePivot('ends_at', '>=', Carbon::now()->toDateString())
			->take($take)
			->get();
	}

	public function all()
	{
		return Collection::all();
	}


	public function allPaginated($perPage = 10)
	{
		return $this->paginateCollection($this->all(), $perPage);
	}


	public function findBySlugOrFail($slug)
	{
		return Collection::findBySlugOrFail($slug);
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

	public function addVenue($venueSlug, Collection $collection, Carbon $start, Carbon $end)
	{
		$collection->venues()->save(Venue::findBySlugOrFail($venueSlug), ['starts_at' => $start, 'ends_at' => $end]);
	}

	public function addVenues(array $venuesArray, Collection $collection, Carbon $start, Carbon $end)
	{
		foreach ($venuesArray as $venueArray)
			$this->addVenue($venueArray['slug'], $collection, $start, $end);
	}
}