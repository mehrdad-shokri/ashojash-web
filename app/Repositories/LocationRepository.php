<?php namespace app\Repository;


use App\Venue;

interface LocationRepository {

	public function create(Venue $venue, $address, $city, $country, $lat, $lng);
}