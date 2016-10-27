<?php namespace app\Repository;


use App\City;
use Illuminate\Support\Facades\DB;

class DbCityRepository implements CityRepository
{

    public function findById($userId)
    {
        return City::findOrFail($userId);
    }

    public function findBySlugOrFail($slug)
    {
        return City::findBySlugOrFail($slug);
    }

    public function available($limit = 20)
    {
        return City::where('status', 1)->take($limit)->get();
    }

    public function all($with = null)
    {
        if (!is_null($with))
            return City::with($with);
        return City::all();
    }

    public function getCity($lat, $lng)
    {
//        $raw = DB::select("select id from cities WHERE st_distance_sphere(point($lat, $lng), point(cities.lat, cities.lng)) <= cities.area;");
        $cityId = DB::table('cities')
            ->select(array('id'))
            ->from('cities')
            ->whereRaw("st_distance_sphere(point($lat, $lng), point(lat, lng)) <= area ")
            ->pluck('id')
            ->first();
        $city = City::where('id', $cityId)->first();
        return $city;
    }

}