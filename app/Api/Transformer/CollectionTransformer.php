<?php

namespace App\Api\Transformer;


use App\City;
use App\Collection;
use app\Repository\DbCollectionRepository;
use app\Repository\DbPhotoRepository;
use League\Fractal\TransformerAbstract;

class CollectionTransformer extends TransformerAbstract {

	protected $defaultIncludes = ['photo', 'venues'];
	protected $collectionRepository;
	/**
	 * @var City
	 */
	private $city;
	/**
	 * @var int
	 */
	private $take;
	private $photoRepository;

	/**
	 * CollectionTransformer constructor.
	 * @param City $city
	 * @param int $take
	 */
	public function __construct(City $city, $take = 20)
	{
		$this->collectionRepository = new DbCollectionRepository();
		$this->photoRepository = new DbPhotoRepository();
		$this->city = $city;
		$this->take = $take;
	}


	public function transform(Collection $collection)
	{
		return [
			'name' => $collection->name,
			'description' => $collection->description,
			'type' => $collection->type,
			'slug' => $collection->slug,
			'shouldShowContent' => $collection->show_content
		];
	}

	public function includeVenues(Collection $collection)
	{
		return $this->collection($this->collectionRepository->venues($collection, $this->city, $this->take), new VenueTransformer());
	}

	public function includePhoto(Collection $collection)
	{
		$photo = $this->photoRepository->collectionPhoto($collection);
		return $this->item($photo, new SimplePhotoTransformer());
	}
}