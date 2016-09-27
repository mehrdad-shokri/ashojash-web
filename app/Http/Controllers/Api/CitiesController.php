<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Http\Controllers\PhotosController;
use app\Repository\CityRepository;
use app\Repository\VenueRepository;
use app\Transformers\CityTransformer;
use app\Transformers\VenueTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CitiesController extends ApiController {

	/**
	 * @var CityRepository
	 */
	private $cityRepository;
	/**
	 * @var CityTransformer
	 */
	private $cityTransformer;
	/**
	 * @var VenueRepository
	 */
	private $venueRepository;
	/**
	 * @var VenueTransformer
	 */
	private $venueTransformer;


	/**
	 * CitiesController constructor.
	 * @param CityRepository $cityRepository
	 * @param CityTransformer $cityTransformer
	 * @param VenueRepository $venueRepository
	 * @param VenueTransformer $venueTransformer
	 */
	public function __construct(CityRepository $cityRepository, CityTransformer $cityTransformer,VenueRepository $venueRepository,VenueTransformer $venueTransformer)
	{
		$this->cityRepository = $cityRepository;
		$this->cityTransformer = $cityTransformer;
		$this->venueRepository = $venueRepository;
		$this->venueTransformer = $venueTransformer;
	}

	public function all()
	{
		$cities = $this->cityRepository->available();
		$array = $this->cityTransformer->transformCollection($cities->toArray());

		return $this->response(['data' => $array]);
		/*
		 * $city = City::findBySlugOrFail($citySlug);
		$venues = $this->venueRepository->setWith('location')->top($city, 3, 3, 'location');
		$array = $this->venueTransformer->transformCollection($venues->toArray());
		return response(['data' => $array]);
		 * */


	}

	public function topVenues(Request $request)
	{
		$request['city-slug'] = $request->route('citySlug');

		$validation = Validator::make($request->all(), [
			'city-slug' => 'required',
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError('invalid input');
		}
		$citySlug = $request->get('city-slug');
		$city = $this->cityRepository->findBySlugOrFail($citySlug);
		$venues = $this->venueRepository->setWith('location')->top($city, 3, 3, 'location');
		$array = $this->venueTransformer->transformCollection($venues->toArray());

		return $this->response(['data' => $array]);
	}

	public function nearbyVenues(Request $request)
	{
		$request['city-slug'] = $request->route('citySlug');
		$request['lat'] = $request->route('lat');
		$request['lng'] = $request->route('lng');
		$validation = Validator::make($request->all(), [
			'city-slug' => 'required',
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError('invalid input');
		}
		$citySlug = $request->get('city-slug');
		$lat = $request->get('lat');
		$lng = $request->get('lng');

		$city = $this->cityRepository->findBySlugOrFail($citySlug);
		$venues = $this->venueRepository->setWith("venue")->nearby($city->getKey(), $lat, $lng);
		$array = $this->venueTransformer->transformCollection($venues->toArray());

		return $this->response(['data' => $array]);
	}

	public function selectedVenues(Request $request)
	{
		$request['city-slug'] = $request->route('citySlug');
		$validation = Validator::make($request->all(), [
			'city-slug' => 'required',
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validation->errors());
		}
		$citySlug = $request->get('city-slug');

		$city = City::findBySlugOrFail($citySlug);
		$venues = $this->venueRepository->setWith(['location'])->top($city, 3, 3);
		$array = $this->venueTransformer->transformCollection($venues->toArray());

		return $this->response(['data' => $array]);
	}
}
