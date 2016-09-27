<?php

namespace app\Repository;


use App\City;
use App\Collection;
use App\Venue;
use Carbon\Carbon;

interface CollectionRepository {

	public function all();

	public function allPaginated($perPage = 10);

	public function create($name, $description = null, $type, $cityId, $active, $startsAt, $endsAt);

	public function cityCollections(City $city);

	public function venues(Collection $collection, City $city);

	public function findBySlugOrFail($slug);

	public function addVenue($venueSlug, Collection $collection, Carbon $start, Carbon $end);

	public function addVenues(array $venueSlugs, Collection $collection, Carbon $start, Carbon $end);
}