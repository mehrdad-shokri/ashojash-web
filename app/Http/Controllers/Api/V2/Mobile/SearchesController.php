<?php

namespace App\Http\Controllers\Api\V2\Mobile;

use App\Api\Transformer\NearbyStreetTransformer;
use App\Api\Transformer\StreetTransformer;
use App\Api\Transformer\VenueTagCombinedTransformer;
use App\Api\Transformer\VenueTransformer;
use App\Http\Controllers\Api\v2\BaseController;
use app\Repository\CityRepository;
use app\Repository\SearchRepository;
use app\Repository\StreetRepository;
use app\Repository\VenueRepository;
use App\VenueTagCombined;
use Illuminate\Http\Request;

class SearchesController extends BaseController {

	/**
	 * @var SearchRepository
	 */
	private $repository;
	/**
	 * @var CityRepository
	 */
	private $cityRepository;
	/**
	 * @var VenueRepository
	 */
	private $venueRepository;

	/**
	 * SearchesController constructor.
	 * @param SearchRepository $repository
	 * @param CityRepository $cityRepository
	 * @param VenueRepository $venueRepository
	 */
	public function __construct(SearchRepository $repository, CityRepository $cityRepository, VenueRepository $venueRepository)
	{
		$this->repository = $repository;
		$this->cityRepository = $cityRepository;
		$this->venueRepository = $venueRepository;
	}

	public function searchVenues(Request $request)
	{
		$lat = $request->get('lat');
		$lng = $request->get('lng');
		$rules = [
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
			'streetName' => 'string',
			'query' => 'string'
		];
		$validator = app('validator')->make($request->all(), $rules);
		if ($validator->fails())
			$this->response->errorBadRequest("Validation failed.");
		$userCity = $this->cityRepository->getCity($lat, $lng);
		if (is_null($userCity))
		{
			return $this->response->errorBadRequest('We are not in your city yet.');
		}
		$queryVenueIds = collect();
		$streetVenueIds = collect();
		$nearbyVenueIds = $this->venueRepository->nearby($lat, $lng, 1, 40)->pluck('id');
		$haveQuery = $request->get('query');
		$haveStreetName = $request->get('streetName');
		if ($haveQuery)
		{
			$queryVenueIds = $this->repository->searchVenue($request->get('query'), $userCity)->pluck('id');
		}
		if ($haveStreetName)
		{
//			dd($this->repository->searchStreet($request->get('streetName'), $userCity)->pluck('name'));
			$streetIds = $this->repository->searchStreet($request->get('streetName'), $userCity)->pluck('OGR_FID');
			foreach ($streetIds as $id)
			{
				$locations = $this->venueRepository->venuesNearStreet($id);
				$locations->each(function ($item) use ($streetVenueIds)
				{
					$streetVenueIds->push($item->venue_id);
				});
			}
			$streetVenueIds = $streetVenueIds->unique();
		}

		if ($haveQuery && $haveStreetName)
		{
//			search in specific street
			$ids = $queryVenueIds->intersect($streetVenueIds)->all();
			$venues = $this->venueRepository->findByIds($ids, $lat, $lng);
			return $this->response->collection($venues, new VenueTransformer());
		}
		if ($haveQuery && !$haveStreetName)
		{
			//			find nearby places with query
			$ids = $queryVenueIds->intersect($nearbyVenueIds)->all();
			$venues = $this->venueRepository->findByIds($ids, $lat, $lng);
			return $this->response->collection($venues, new VenueTransformer());
		}
		if (!$haveQuery && $haveStreetName)
		{
//			find venues in specif street
			$ids = $streetVenueIds->all();
			$venues = $this->venueRepository->findByIds($ids, $lat, $lng);
			return $this->response->collection($venues, new VenueTransformer());
		}
		if (!$haveQuery && !$haveStreetName)
		{
//			find all nearby places
			$ids = $nearbyVenueIds->all();
			$venues = $this->venueRepository->findByIds($ids, $lat, $lng);
			return $this->response->collection($venues, new VenueTransformer());
		}
	}

	public function suggestVenues(Request $request)
	{
		$lat = $request->get('lat');
		$lng = $request->get('lng');
		$rules = [
			'query' => 'required|string',
			'lat' => 'required|numeric',
			'lng' => 'required|numeric'
		];
		$validator = app('validator')->make($request->all(), $rules);
		if ($validator->fails())
			$this->response->errorBadRequest("Validation failed.");
		$userCity = $this->cityRepository->getCity($lat, $lng);
		if (is_null($userCity))
		{
			return $this->response->errorBadRequest("We are not in your city yet.");
		}
		$tags = $this->repository->suggestTag($request->get('query'));
		$venues = $this->repository->suggestVenue($request->get('query'));
		$cityVenue = $this->venueRepository->cityVenues($userCity);
		$venues = $venues->whereIn('id', $cityVenue->pluck('id')->all());
		$venueTagsCombined = new VenueTagCombined($venues, $tags);
		return $this->response->item($venueTagsCombined, new VenueTagCombinedTransformer());
	}

	public function suggestStreets(Request $request)
	{
		$lat = $request->get('lat');
		$lng = $request->get('lng');
		$rules = [
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
			'query' => 'required|string'
		];
		$validator = app('validator')->make($request->all(), $rules);
		if ($validator->fails())
			$this->response->errorBadRequest($this->errorResponse($validator));
		$userCity = $this->cityRepository->getCity($lat, $lng);
		if (is_null($userCity))
		{
			return $this->response->errorBadRequest("We are not in your city yet");
		}
		$streets = $this->repository->suggestStreet($request->get('query'), $userCity);
		$streets = $streets->unique('name');
		return $this->response->collection($streets, new StreetTransformer());
	}

	public function nearbyStreets(Request $request, StreetRepository $repository)
	{
		$lat = $request->get('lat');
		$lng = $request->get('lng');
		$rules = [
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
		];
		$validator = app('validator')->make($request->all(), $rules);
		if ($validator->fails())
			$this->response->errorBadRequest("Validation failed.");
		$userCity = $this->cityRepository->getCity($lat, $lng);
		if (is_null($userCity))
		{
			return $this->response->errorBadRequest('We are not in your city yet.');
		}
		$nearbyStreets = $repository->nearbyStreets($lat, $lng);
		$nearbyStreets = $nearbyStreets->unique('name');
		return $this->response->collection($nearbyStreets, new NearbyStreetTransformer());
	}
}