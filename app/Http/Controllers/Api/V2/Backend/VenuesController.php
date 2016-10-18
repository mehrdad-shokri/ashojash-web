<?php

namespace App\Http\Controllers\Api\V2\Backend;


use App\Api\Transformer\Backend\CollectionTransformer;
use App\Api\Transformer\Backend\TagTransformer;
use App\Api\Transformer\CityTransformer;
use App\Api\Transformer\VenueTransformer;
use App\City;
use App\Collection;
use App\Http\Controllers\Api\v2\BaseController;
use app\Repository\CityRepository;
use app\Repository\CollectionRepository;
use app\Repository\TagRepository;
use app\Repository\VenueRepository;
use App\Tag;
use App\Venue;
use Carbon\Carbon;
use Dingo\Api\Routing\Adapter\Laravel;
use FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Vinkla\Hashids\Facades\Hashids;

class VenuesController extends BaseController {

	/**
	 * @var TagRepository
	 */
	private $venueRepository;
	/**
	 * @var CityRepository
	 */
	private $cityRepository;

	public function __construct(VenueRepository $venueRepository, CityRepository $cityRepository)
	{
		$this->venueRepository = $venueRepository;
		$this->cityRepository = $cityRepository;
	}

	public function all(Request $request)
	{
		$rules = [
			'slug' => 'string|exists:cities,slug'
		];
		$validator = app('validator')->make($request->all(), $rules);
		if ($validator->fails())
		{
			$this->response->errorBadRequest($this->errorResponse($validator));
		}
		$citySlug = $request->get('slug');
		if ($citySlug)
		{
			$city = $this->cityRepository->findBySlugOrFail($citySlug);
			$venues = $this->venueRepository->cityVenues($city);
		}
		else
		{
			$venues = $this->venueRepository->all();
		}
		return $this->response->collection($venues, new VenueTransformer());
	}
}