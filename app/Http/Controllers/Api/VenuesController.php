<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Http\Requests;
use app\Repository\CityRepository;
use app\Repository\MenuRepository;
use app\Repository\PhotoRepository;
use app\Repository\ReviewRepository;
use app\Repository\VenueRepository;
use App\Review;
use app\Transformers\ReviewTransformer;
use app\Transformers\VenuePhotoTransformer;
use app\Transformers\VenueTransformer;
use App\User;
use App\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class VenuesController extends ApiController {

	/**
	 * @var VenueRepository
	 */
	private $venueRepository;
	/**
	 * @var VenueTransformer
	 */
	private $venueTransformer;
	/**
	 * @var CityRepository
	 */
	private $cityRepository;
	/**
	 * @var \MenuTransformer
	 */
	private $menuTransformer;
	/**
	 * @var ReviewTransformer
	 */
	private $reviewTransformer;
	/**
	 * @var VenuePhotoTransformer
	 */
	private $venuePhotoTransformer;
	/**
	 * @var ReviewRepository
	 */
	private $reviewRepository;
	/**
	 * @var MenuRepository
	 */
	private $menuRepository;
	/**
	 * @var PhotoRepository
	 */
	private $photoRepository;

	/**
	 * VenuesController constructor.
	 * @param VenueRepository $venueRepository
	 * @param VenueTransformer $venueTransformer
	 * @param CityRepository $cityRepository
	 * @param \MenuTransformer $menuTransformer
	 * @param ReviewTransformer $reviewTransformer
	 * @param VenuePhotoTransformer $venuePhotoTransformer
	 * @param ReviewRepository $reviewRepository
	 * @param MenuRepository $menuRepository
	 * @param PhotoRepository $photoRepository
	 */
	public function __construct(VenueRepository $venueRepository, VenueTransformer $venueTransformer, CityRepository $cityRepository, \MenuTransformer $menuTransformer, ReviewTransformer $reviewTransformer, VenuePhotoTransformer $venuePhotoTransformer, ReviewRepository $reviewRepository, MenuRepository $menuRepository, PhotoRepository $photoRepository)
	{
		$this->venueRepository = $venueRepository;
		$this->venueTransformer = $venueTransformer;
		$this->cityRepository = $cityRepository;
		$this->menuTransformer = $menuTransformer;
		$this->reviewTransformer = $reviewTransformer;
		$this->venuePhotoTransformer = $venuePhotoTransformer;
		$this->reviewRepository = $reviewRepository;
		$this->menuRepository = $menuRepository;
		$this->photoRepository = $photoRepository;
	}

	public function index(Request $request)
	{
//			sleep(2);
		$request['venue-slug'] = $request->route('venueSlug');
		$validation = Validator::make($request->all(), [
			'venue-slug' => 'required'
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError('invalid input');
		}
		$venueSlug = $request->get('venue-slug');
		$venue = $this->venueRepository->setWith("location")->findBySlugOrFail($venueSlug);
		$venueArray = $this->venueTransformer->transform($venue->toArray());
//			$reviews = $venue->reviews()->orderBy('created_at', 'desc')->where('quality','<',0)->take(5)->get();
		$reviews = $venue->reviews()->orderBy('created_at', 'desc')->take(3)->get();
		$photos = $venue->photos()->orderBy("created_at", 'desc')->take(3)->get();
		$menus = $venue->menus()->take(3)->get();
		$reviews->map(function ($item, $key)
		{
			return $item['user_image_url'] = action("PhotosController@getUserAvatar", [$item->user->username]);
		});
		$photos->map(function ($item, $key)
		{
			return $item['username'] = $item->user->username;
		});
		$data = array();
		$data['venue'] = $venueArray;
		$data['menus'] = $this->menuTransformer->transformCollection($menus->toArray());
		$data['reviews'] = $this->reviewTransformer->transformCollection($reviews->toArray());
		$data['photos'] = $this->venuePhotoTransformer->transformCollection($photos->toArray());

		$data['reviews_count'] = $venue->reviews()->count();
		$data['menus_count'] = $venue->menus()->count();

		return $this->response(['data' => $data]);

	}

	public function reviews(Request $request, $venueSlug)
	{
		$request['venue-slug'] = $venueSlug;
		$validation = Validator::make($request->all(), [
			'venue-slug' => 'required|exists:venues,slug'
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validation->errors());
		}
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$baseLimit = 8;
		$limit = $request->get('limit') ?: $baseLimit;
		$limit = $limit > 20 ? $baseLimit : $limit;
		$reviews = $this->reviewRepository->venueReviewsPaginated($venue, $limit);
		$reviewsArray = array();
		for ($i = 0; $i < count($reviews->items()); $i++)
		{
			$array = $reviews[$i]->toArray();
			$array['user_image_url'] = action("PhotosController@getUserAvatar", [$reviews[$i]->user->username]);
			$reviewsArray[] = $array;
		}
		return $this->respondWithPagination($reviews, $this->reviewTransformer->transformCollection($reviewsArray));
	}

	public function menus(Request $request, $venueSlug)
	{
		$request['venue-slug'] = $venueSlug;
		$validation = Validator::make($request->all(), [
			'venue-slug' => 'required|exists:venues,slug'
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validation->errors());
		}
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$baseLimit = 8;
		$limit = $request->get('limit') ?: $baseLimit;
		$limit = $limit > 20 ? $baseLimit : $limit;
		$menus = $this->menuRepository->menuPaginated($venue, $limit);
		$menusArray = array();
		for ($i = 0; $i < count($menus->items()); $i++)
		{
			$array = $menus[$i]->toArray();
			$menusArray[] = $array;
		}
		return $this->respondWithPagination($menus, $this->menuTransformer->transformCollection($menusArray));
	}

	public function photos(Request $request, $venueSlug)
	{
		$request['venue-slug'] = $venueSlug;
		$validation = Validator::make($request->all(), [
			'venue-slug' => 'required|exists:venues,slug'
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validation->errors());
		}
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$baseLimit = 8;
		$limit = $request->get('limit') ?: $baseLimit;
		$limit = $limit > 20 ? $baseLimit : $limit;
		$photos = $this->photoRepository->venuePhotosPaginated($venue, $limit);
		$photosArray = array();
		for ($i = 0; $i < count($photos->items()); $i++)
		{
			$array = $photos[$i]->toArray();
			$array['username'] = $photos[$i]->user->username;
			$photosArray[] = $array;
		}
		return $this->respondWithPagination($photos, $this->venuePhotoTransformer->transformCollection($photosArray));
	}

	public function search(Request $request, $citySlug)
	{
		$request['city-slug'] = $request->route('citySlug');
		$query = $request->get('q');
		$limit = $request->get('l');
		$validation = Validator::make($request->all(), [
			'q' => 'required|min:3',
			'city-slug' => 'required|exists:cities,slug',
			'l' => 'required|integer'
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validation->errors());
		}
		$city = $this->cityRepository->findBySlugOrFail($citySlug);
		$venues = $this->venueRepository->search($query, $city, $limit);
		$data = $this->venueTransformer->transformCollection($venues->toArray());
		return $this->response(['data' => $data]);
	}

}
