<?php

namespace App\Http\Controllers\Api\V3\Mobile;

use App\Api\Transformer\MenuTransformer;
use App\Api\Transformer\PhotoTransformer;
use App\Api\Transformer\ReviewTransformer;
use App\Api\Transformer\VenueTransformer;
use App\Http\Controllers\Api\v2\BaseController;
use App\Http\Requests;
use app\Repository\CityRepository;
use app\Repository\MenuRepository;
use app\Repository\PhotoRepository;
use app\Repository\ReviewRepository;
use app\Repository\VenueRepository;
use Illuminate\Http\Request;

class SearchesController extends BaseController {

	/**
	 * @var VenueRepository
	 */
	private $venueRepository;
	/**
	 * @var CityRepository
	 */
	private $cityRepository;

	/**
	 * VenuesController constructor.
	 * @param VenueRepository $venueRepository
	 * @param CityRepository $cityRepository
	 */
	public function __construct(VenueRepository $venueRepository, CityRepository $cityRepository)
	{
		$this->venueRepository = $venueRepository;
		$this->cityRepository = $cityRepository;
	}

	public function search(Request $request, $citySlug)
	{
		$rules = [
			$this->citySlugRule,
			'query' => 'required|min:3',
			'limit' => 'sometimes|integer|min:1',
			'address' => 'required'
		];
		$query = $request->get('q');
		$limit = $request->get('l');
		if (is_null($limit)) $limit = 7;
		$validator = app('validator')->make(compact('citySlug', 'query', 'limit', 'address'), $rules);
		$this->handleValidation($validator);

		$city = $this->cityRepository->findBySlugOrFail($citySlug);
		$venues = $this->venueRepository->searchPaginated($query, $city, $limit);
		return $this->response->paginator($venues, new VenueTransformer(), ['key' => 'data']);
	}

	public function nearby(Request $request)
	{
		$rules = [
			$this->citySlugRule,
			'query' => 'required|min:3',
			'limit' => 'sometimes|integer|min:1'
		];
		$query = $request->get('q');
		$limit = $request->get('l');
		if (is_null($limit)) $limit = 4;

	}
}
