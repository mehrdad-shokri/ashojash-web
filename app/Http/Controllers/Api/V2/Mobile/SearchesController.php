<?php

namespace App\Http\Controllers\Api\V2\Mobile;

use App\Api\Transformer\StreetTransformer;
use App\Api\Transformer\VenueTransformer;
use App\City;
use App\Http\Controllers\Api\v2\BaseController;
use App\Location;
use app\Repository\CityRepository;
use app\Repository\SearchRepository;
use App\Tag;
use App\Venue;
use Hamcrest\Collection\IsTraversableWithSizeTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchesController extends BaseController {

	/**
	 * @var SearchRepository
	 */
	private $repository;
	/**
	 * @var CityRepository
	 */
	private $cityRepository;

	public function __construct(SearchRepository $repository, CityRepository $cityRepository)
	{
		$this->repository = $repository;
		$this->cityRepository = $cityRepository;
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
		$validator = app('validator')->make(compact('lat', 'lng'), $rules);
		if ($validator->fails())
			$this->response->errorBadRequest("Validation failed.");
		$userCity = $this->cityRepository->getCity($lat, $lng);
		if ($request->get('streetName'))
		{
			$streetIds = $this->repository->searchStreet($request->get('streetName'), $userCity)->pluck('OGR_FID');
			$streetVenueIds = collect();
			foreach ($streetIds as $id)
			{
				$locations = DB::table(DB::raw("locations,streets"))->select(DB::raw("ST_DISTANCE(geolocation,shape)*100000 as distance , venue_id"))->where('OGR_FID', $id)->orderBy('distance', 'asc')->havingRaw("distance < 200")->get();
				$locations->each(function ($item) use ($streetVenueIds)
				{
					$streetVenueIds->push($item->venue_id);
				});
			}
			$streetVenueIds = $streetVenueIds->unique();
			if (!$request->get('query'))
			{
				if ($streetVenueIds->count() == 0)
				{
					return $this->response->collection(collect(), new VenueTransformer());
				}
				$venueIdsArray = $streetVenueIds->all();
				$idsImploded = implode(',', $venueIdsArray);
				$venues = Venue::whereIn('id', $venueIdsArray)->orderByRaw("field(id,{$idsImploded})", $venueIdsArray)->get();
				return $this->response->collection($venues, new VenueTransformer());
			}
			else
			{
				$queryVenueIds = $this->repository->suggestVenue($request->get('query'))->pluck('id');
				$ids = $queryVenueIds->intersect($streetVenueIds)->all();
				$idsImploded = implode(',', $ids);
				$venues = Venue::whereIn('id', $ids)->orderByRaw("field(id,{$idsImploded})", $ids)->get();
				return $this->response->collection($venues, new VenueTransformer());
			}
			$venues = $this->repository->suggestVenue($request->get('query'));
		}
		else
		{
			//			find nearby places
			if ($request->get('query'))
			{

			}
			else
			{

			}
		}

	}


	public function suggestStreets(Request $request)
	{
		$lat = $request->get('lat');
		$lng = $request->get('lng');
		$rules = [
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
			'name' => 'string'
		];
		$validator = app('validator')->make(compact('lat', 'lng'), $rules);
		if ($validator->fails())
			$this->response->errorBadRequest("Validation failed.");
		$userCity = $this->cityRepository->getCity($lat, $lng);
		return $this->response->collection($this->repository->suggestStreet($request->get('name'), $userCity), new StreetTransformer());
	}
}