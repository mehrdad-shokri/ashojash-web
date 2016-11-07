<?php

namespace App\Api\Transformer;


use App\Street;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Token;

class NearbyStreetTransformer extends TransformerAbstract {


	public function transform($street)
	{
		return [
			'name' => $street->name,
			'distance' => $street->distance
		];
	}
}