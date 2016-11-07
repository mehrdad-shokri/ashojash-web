<?php

namespace app\Repository;


use Illuminate\Support\Facades\DB;

class DbStreetRepository implements StreetRepository {

	public function nearbyStreets($lat, $lng, $distance = 300)
	{
		$streets = DB::table(DB::raw("streets"))->select(DB::raw("ST_DISTANCE(POINT($lng , $lat),shape)*100000 as distance ,name"))->orderBy('distance', 'asc')->havingRaw("distance < $distance")->get();
		return $streets;
	}
}