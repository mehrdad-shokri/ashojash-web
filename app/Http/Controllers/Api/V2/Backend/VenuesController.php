<?php

namespace App\Http\Controllers\Api\V2\Backend;


use App\Api\NoDataArraySerializer;
use App\Api\PaginatorArraySerializer;
use App\Api\Transformer\Backend\CollectionTransformer;
use App\Api\Transformer\Backend\TagTransformer;
use App\Api\Transformer\Backend\VenueTagTransformer;
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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;
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
	/**
	 * @var TagRepository
	 */
	private $tagRepository;

	/**
	 * VenuesController constructor.
	 * @param VenueRepository $venueRepository
	 * @param CityRepository $cityRepository
	 * @param TagRepository $tagRepository
	 */
	public function __construct(VenueRepository $venueRepository, CityRepository $cityRepository, TagRepository $tagRepository)
	{
		$this->venueRepository = $venueRepository;
		$this->cityRepository = $cityRepository;
		$this->tagRepository = $tagRepository;
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
		$venuesPaginated = $this->venueRepository->paginateCollection($venues, 30, 'page');
		return $this->response->paginator($venuesPaginated, new VenueTransformer, [], function ($resource, $fractal)
		{
			$fractal->setSerializer(new ArraySerializer());
		});
	}

	public function tags(Request $request)
	{
		$venue = $this->venueRepository->findBySlugOrFail($request->route('slug'));
//		dd($venue->tags->first());
		return $this->response->collection($venue->tags()->orderBy('tag_venue.created_at', 'desc')->get(), new VenueTagTransformer());
	}

	public function searchTag(Request $request)
	{
		$rules = [
			'query' => 'required|string',
		];
		$validator = app('validator')->make($request->all(), $rules);
		if ($validator->fails())
		{
			$this->response->errorBadRequest($this->errorResponse($validator));
		}
		$venue = $this->venueRepository->findBySlugOrFail($request->route('slug'));
		return $this->response->collection($this->venueRepository->searchTag($venue, $request->get('query')), new TagTransformer());
	}

	public function addTag(Request $request)
	{
		$rules = [
			'name' => 'string|required',
			'weight' => 'required|integer|min:1|max:100'
		];
		$validator = app('validator')->make($request->all(), $rules);
		if ($validator->fails())
		{
			$this->response->errorBadRequest($this->errorResponse($validator));
		}
		$tag = $this->tagRepository->findByNameOrFail($request->get('name'));
		$venue = $this->venueRepository->findBySlugOrFail($request->route('slug'));
		$this->tagRepository->addTag($venue, $request->get('weight'), $tag);
		return $this->response->created();
	}
}