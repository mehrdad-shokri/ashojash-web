<?php namespace app\Repository;


interface CityRepository
{

    public function findBySlugOrFail($slug);

    public function findById($userId);

    public function all($with);

    public function available($limit = 20);

    public function getCity($lat, $lng);
//	public function venuesByCuisineSlug ($slug);

}