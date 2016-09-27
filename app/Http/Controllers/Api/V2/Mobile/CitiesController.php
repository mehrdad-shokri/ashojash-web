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

	public function nearbyVenues(Request $request, $lat, $lng)
	{
		$distance = $request->get('distance');
		$limit = $request->get('limit');
		$rules = [
			'distance' => 'numeric',
			'limit' => 'integer',
			'lat' => 'required|numeric',
			'lng' => 'required|numeric'
		];
		$validator = app('validator')->make(compact('limit', 'distance', 'lat', 'lng'), $rules);
		if ($validator->fails())
			return $this->response->errorBadRequest("Validation failed");
		$venues = $this->venueRepository->setWith("venue")->nearby($lat, $lng, $distance, $limit);
		return $this->response->collection($venues, new VenueTransformer());
	}
}