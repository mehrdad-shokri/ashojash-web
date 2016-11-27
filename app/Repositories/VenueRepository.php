<?php

namespace app\Repository;


use App\City;
use App\Venue;
use PhpParser\Node\Expr\Array_;

interface VenueRepository {

	public function findBySlugOrFail($slug);

	public function findById($id);

	public function findByIds($ids, City $city, $lat, $lng);

	public function all($with);

	public function create($name, $phone, $status = 0);

	public function whereCity($slug, City $city);

	public function currentDaySchedule(Venue $venue);

	public function schedules(Venue $venue);

	public function update(Venue $venue, $name = null, $address = null, $phone = null, $instagram = null, $url = null);

	public function top(City $city, $scoreGreaterEqual = 3, $count = 3);

	public function cityVenues(City $city);

	public function setWith($with);

	public function getWith();

	public function nearby($userLat, $userLng, $distance = 5, $limit = 20);

	public function search($query, City $city, $limit = 20);

	public function searchPaginated($query, City $city, $perPage = 4);

	public function venueReviewsCount(Venue $venue);

	public function venuePhotosCount(Venue $venue);

	public function venueMenusCount(Venue $venue);

	public function searchTag(Venue $venue, $query, $filter = true);

	public function venuesNearStreet($streetId);
}