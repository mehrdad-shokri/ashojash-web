<?php

namespace app\Repository;


use App\City;

interface SearchRepository {

	public function suggestVenue($name,$limit=100);

	public function searchVenue($name,$limit=100);

	public function suggestStreet($name, City $city);

	public function searchStreet($name, City $city);

	public function suggestTag($name);
}