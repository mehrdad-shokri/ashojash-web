<?php namespace app\Repository;


use App\Country;

class DbCountryRepository implements CountryRepository {

	public function first()
	{
		return Country::first();
	}
}