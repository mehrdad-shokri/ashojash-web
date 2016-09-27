<?php namespace App\Api\Transformer;


use App\Location;
use League\Fractal\TransformerAbstract;

class LocationTransformer extends TransformerAbstract {

	public function transform(Location $location)
	{
		$array = array(
			'lat' => $location->lat,
			'lng' => $location->lng,
			'address' => $location->address
		);
		if (isset($location->distance))
			$array['distance'] = $location->distance;
		return $array;
	}
}