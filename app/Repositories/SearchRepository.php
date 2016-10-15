<?php

namespace app\Repository;


use App\City;

interface SearchRepository
{
    public function suggestVenue($name, City $city);

    public function searchVenue($name, City $city);

    public function suggestStreet($name, City $city);

    public function searchStreet($name, City $city);
}