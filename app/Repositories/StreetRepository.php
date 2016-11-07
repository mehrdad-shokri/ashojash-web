<?php

namespace app\Repository;


interface StreetRepository {

	function nearbyStreets($lat, $lng, $distance = 300);
}