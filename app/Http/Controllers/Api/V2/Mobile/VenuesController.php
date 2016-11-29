<?php

namespace App\Http\Controllers\Api\V2\Mobile;

use App\Api\Transformer\MenuTransformer;
use App\Api\Transformer\PhotoTransformer;
use App\Api\Transformer\ReviewTransformer;
use App\Api\Transformer\VenueTransformer;
use App\Http\Controllers\Api\v2\BaseController;
use app\Repository\CityRepository;
use app\Repository\MenuRepository;
use app\Repository\PhotoRepository;
use app\Repository\ReviewRepository;
use app\Repository\VenueRepository;
use Illuminate\Http\Request;

class VenuesController extends BaseController {

	/**
	 * @var VenueRepository
	 */
	private $venueRepository;
	/**
	 * @var CityRepository
	 */
	private $cityRepository;
	/**
	 * @var MenuRepository
	 */
	private $menuRepository;
	/**
	 * @var PhotoRepository
	 */
	private $photoRepository;
	/**
	 * @var ReviewRepository
	 */
	private $reviewRepository;

	/**
	 * VenuesController constructor.
	 * @param VenueRepository $venueRepository
	 * @param CityRepository $cityRepository
	 * @param ReviewRepository $reviewRepository
	 * @param MenuRepository $menuRepository
	 * @param PhotoRepository $photoRepository
	 */
	public function __construct(VenueRepository $venueRepository, CityRepository $cityRepository, ReviewRepository $reviewRepository, MenuRepository $menuRepository, PhotoRepository $photoRepository)
	{
		$this->venueRepository = $venueRepository;
		$this->cityRepository = $cityRepository;
		$this->menuRepository = $menuRepository;
		$this->photoRepository = $photoRepository;
		$this->reviewRepository = $reviewRepository;
	}

	private $venueSlugRule = array("venueSlug" => "required|exists:venues,slug");

	public function index($venueSlug)
	{
		$rules = [
			$this->venueSlugRule
		];
		$validator = app('validator')->make(compact('venueSlug'), $rules);
		$this->handleValidation($validator);
		$venue = $this->venueRepository->setWith("location")->findBySlugOrFail($venueSlug);
		return $this->response->item($venue, new VenueTransformer());
	}

	/**
	 * Deprecated
	 */
	public function search(Request $request, $citySlug)
	{
		$query = $request->get('q');
		$limit = $request->get('l');
		$rules = [
			$this->citySlugRule,
			'query' => 'required|min:3',
			'limit' => 'sometimes|integer|min:1'
		];
		if (is_null($limit)) $limit = 4;
		$validator = app('validator')->make(compact('citySlug', 'query', 'limit'), $rules);
		$this->handleValidation($validator);
		$city = $this->cityRepository->findBySlugOrFail($citySlug);
		$venues = $this->venueRepository->searchPaginated($query, $city, $limit);
		return $this->response->paginator($venues, new VenueTransformer(), ['key' => 'data']);
	}

	public function reviews($venueSlug)
	{
		$rules = [
			$this->venueSlugRule
		];
		$validator = app('validator')->make(compact('venueSlug'), $rules);
		$this->handleValidation($validator);
		$venue = $this->venueRepository->setWith("location")->findBySlugOrFail($venueSlug);
		$reviews = $this->reviewRepository->venueReviews($venue)->get();
		return $this->response->collection($reviews, new ReviewTransformer());
	}

	public function menus($venueSlug)
	{
		$rules = [
			$this->venueSlugRule
		];
		$validator = app('validator')->make(compact('venueSlug'), $rules);
		$this->handleValidation($validator);
		$venue = $this->venueRepository->setWith("location")->findBySlugOrFail($venueSlug);
		$menus = $this->menuRepository->menus($venue);
		return $this->response->collection($menus, new MenuTransformer());
	}

	public function photos($venueSlug)
	{
		$rules = [
			$this->venueSlugRule
		];
		$validator = app('validator')->make(compact('venueSlug'), $rules);
		$this->handleValidation($validator);
		$venue = $this->venueRepository->setWith("location")->findBySlugOrFail($venueSlug);
		$photos = $this->photoRepository->venuePhotos($venue);
		return $this->response->collection($photos, new PhotoTransformer());
	}
}
