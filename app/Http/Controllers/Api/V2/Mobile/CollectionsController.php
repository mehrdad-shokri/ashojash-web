<?php

namespace App\Http\Controllers\Api\v2\Mobile;

use App\Api\Transformer\CollectionTransformer;
use App\Http\Controllers\Api\v2\BaseController;
use app\Repository\CityRepository;
use app\Repository\CollectionRepository;

class CollectionsController extends BaseController {

	/**
	 * @var CollectionRepository
	 */
	private $collectionRepository;
	/**
	 * @var CityRepository
	 */
	private $cityRepository;

	/**
	 * CollectionsController constructor.
	 * @param CollectionRepository $collectionRepository
	 * @param CityRepository $cityRepository
	 */
	public function __construct(CollectionRepository $collectionRepository, CityRepository $cityRepository)
	{
		$this->collectionRepository = $collectionRepository;
		$this->cityRepository = $cityRepository;
	}

	public function all($citySlug)
	{
		$rules = [
			'citySlug' => 'required|exists:cities,slug'
		];
		$validator = app('validator')->make(compact("citySlug"), $rules);
		if ($validator->fails())
			$this->response->errorBadRequest("Validation failed.");
		$city = $this->cityRepository->findBySlugOrFail($citySlug);
		$collections = $this->collectionRepository->cityCollections($city);
		return $this->response->collection($collections, new CollectionTransformer($city, 4));
	}

	public function index($citySlug, $collectionSlug)
	{
		$rules = [
			'collectionSlug' => 'required|exists:collections,slug',
			'citySlug' => 'required|exists:cities,slug'
		];
		$validator = app('validator')->make(compact("collectionSlug", "citySlug"), $rules);
		if ($validator->fails())
			$this->response->errorBadRequest($validator->errors());
		$city = $this->cityRepository->findBySlugOrFail($citySlug);
		$collection = $this->collectionRepository->findBySlugOrFail($collectionSlug);
		return $this->response->item($collection, new CollectionTransformer($city, null));
	}

}
