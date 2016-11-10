<?php

namespace app\Repository;


use Illuminate\Support\Facades\DB;

class DbStreetRepository implements StreetRepository {

	public function nearbyStreets($lat, $lng, $limit = 15)
	{
		$streets = DB::table(DB::raw("streets"))->select(DB::raw("ST_DISTANCE(POINT($lng , $lat),shape)*100000 as distance ,name"))->orderBy('distance', 'asc')->take($limit)->get();

		return $streets;
	}
}