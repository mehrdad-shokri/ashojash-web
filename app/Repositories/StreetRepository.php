<?php

namespace app\Repository;


interface StreetRepository {

	function nearbyStreets($lat, $lng, $limit = 15);
}