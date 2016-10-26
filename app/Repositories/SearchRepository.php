<?php

namespace app\Repository;


use App\City;

interface SearchRepository
{
    public function suggestVenue($name);

    public function searchVenue($name);

    public function suggestStreet($name, City $city);

    public function searchStreet($name, City $city);
}