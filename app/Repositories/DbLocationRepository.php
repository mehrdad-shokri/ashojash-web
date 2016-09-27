<?php namespace app\Repository;


use App\Venue;

class DbLocationRepository implements LocationRepository {

	public function create(Venue $venue, $address, $city, $country, $lat, $lng)
	{
		$venue->location()->create(['address' => $address, 'city_id' => $city, 'country_id' => $country, 'lat' => $lat, 'lng' => $lng]);
	}
}