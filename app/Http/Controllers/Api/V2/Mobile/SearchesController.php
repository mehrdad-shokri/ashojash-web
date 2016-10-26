<?php

namespace App\Http\Controllers\Api\V2\Mobile;

use App\Api\Transformer\StreetTransformer;
use App\City;
use App\Http\Controllers\Api\v2\BaseController;
use App\Location;
use app\Repository\CityRepository;
use app\Repository\SearchRepository;
use App\Tag;
use App\Venue;
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
		if ($request->get('streetName'))  //find in that place
		{
			$streetIds = $this->repository->searchStreet($request->get('streetName'), $userCity)->pluck('OGR_FID');
			$venueIds = collect();
			foreach ($streetIds as $id)
			{
				$locations = DB::table(DB::raw("locations,streets"))->where('OGR_FID', $id)->whereRaw("ST_DISTANCE(geolocation,shape)*100000 as distance < 200")->get();
				$locations->each(function ($item) use ($venueIds)
				{
					$venueIds->push($item->venue_id);
				});
				dd($locations);
			}
			dd($this->repository->suggestStreet($request->get('streetName'),$userCity));
			if (!$request->get('query'))
			{
				return $this->repository->searchStreet($request->get('name'), $userCity);
			}
			$venues = $this->repository->suggestVenue($request->get('query'));

		}
		else
		{
//			find nearby places
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