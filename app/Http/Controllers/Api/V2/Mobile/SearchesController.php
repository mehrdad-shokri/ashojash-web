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
use App\Venue;
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
			'limit' => 'integer|min:1|max:100',
			'streetName' => 'string',
			'query' => 'string'
		];
		$validator = app('validator')->make($request->all(), $rules);
		if ($validator->fails())
			$this->response->errorBadRequest("Validation failed.");
		$userCity = $this->cityRepository->getCity($lat, $lng);
		$limit = ($request->get('limit')) ? (int) $request->get('limit') : 30;
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
			$queryVenueIds = $this->repository->searchVenue($request->get('query'))->pluck('id');
		}
		if ($haveStreetName)
		{
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
			$venues = $this->venueRepository->findByIds($ids, $userCity, $lat, $lng)->take($limit);
			return $this->response->collection($venues, new VenueTransformer());
		}
		if ($haveQuery && !$haveStreetName)
		{
			/*
			$ids = $queryVenueIds->intersect($nearbyVenueIds)->all();
			if (sizeof($ids) == 0) $ids = $queryVenueIds->toArray();
			$venues = $this->venueRepository->findByIds($ids, $userCity, $lat, $lng);
			*/

			/*
			 * SEARCHING FOR A SPECIFIC VENUE SHOULD BRING THAT ONLY
			 * SEARCHING FOR GENERAL TERMS SHOULD ONLY BRING NEARBY RESULTS
			 * */
			/*
			 * NOW WE ARE RETURNING RESULTS BASED ON QUERY RELEVANCE THERE SHOULD BE A QUERY PARAM TO SORT IT BY DISTANCE
			 * */
			$venues = $this->venueRepository->findByIds($queryVenueIds->all(), $userCity, $lat, $lng)->take($limit);
			$venues = $venues->sortBy('distance');
			return $this->response->collection($venues, new VenueTransformer());
		}
		if (!$haveQuery && $haveStreetName)
		{
//			find venues in specif street
			$ids = $streetVenueIds->all();
			$venues = $this->venueRepository->findByIds($ids, $userCity, $lat, $lng)->take($limit);
			return $this->response->collection($venues, new VenueTransformer());
		}
		if (!$haveQuery && !$haveStreetName)
		{
//			find all nearby places
			$ids = $nearbyVenueIds->all();
			$venues = $this->venueRepository->findByIds($ids, $userCity, $lat, $lng)->take($limit);
			return $this->response->collection($venues, new VenueTransformer());
		}
	}

	public function suggestTerm(Request $request)
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
		$venues = $this->repository->suggestVenue($request->get('query'));
		$venues = $this->venueRepository->findByIds($venues->pluck('id')->all(), $userCity, $lat, $lng);
		$tags = $this->repository->suggestTag($request->get('query'));
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