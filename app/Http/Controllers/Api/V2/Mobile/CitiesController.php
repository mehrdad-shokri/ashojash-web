<?php

namespace App\Http\Controllers\Api\V2\Mobile;

use App\Api\Transformer\CityTransformer;
use App\Api\Transformer\VenueTransformer;
use App\City;
use App\Http\Controllers\Api\v2\BaseController;
use App\Http\Requests;
use app\Repository\CityRepository;
use app\Repository\VenueRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CitiesController extends BaseController {

	private $cityRepository;
	private $venueRepository;


	/**
	 * CitiesController constructor.
	 * @param CityRepository $cityRepository
	 * @param VenueRepository $venueRepository
	 */
	public function __construct(CityRepository $cityRepository, VenueRepository $venueRepository)
	{
		$this->cityRepository = $cityRepository;
		$this->venueRepository = $venueRepository;
	}

	public function index($citySlug)
	{
		$rules = [
			$this->citySlugRule
		];
		$validator = app('validator')->make(compact('citySlug', 'lat', 'lng'), $rules);
		if ($validator->fails())
		{
			$this->response->errorBadRequest("Validation failed");
		}
		$city = $this->cityRepository->findBySlugOrFail($citySlug);
		return $this->response->item($city, new CityTransformer());
	}

	public function all()
	{
		$cities = $this->cityRepository->available();
		return $this->response->collection($cities, new CityTransformer());
	}

	public function nearbyVenues(Request $request)
	{
		$rules = [
			'distance' => 'numeric|max:6',
			'limit' => 'integer|min:1|max:60',
			'lat' => 'required|numeric',
			'lng' => 'required|numeric'
		];
		$validator = app('validator')->make($request->all(), $rules);
		if ($validator->fails())
			return $this->response->errorBadRequest("Validation failed");
		$distance = $request->get('distance');
		$limit = $request->get('limit') ? (int) $request->get('limit') : 30;
		$lat = $request->get('lat');
		$lng = $request->get('lng');
		$venues = $this->venueRepository->nearby($lat, $lng, $distance, $limit);
		return $this->response->collection($venues, new VenueTransformer());
	}
}