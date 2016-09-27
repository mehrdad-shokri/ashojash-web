<?php

namespace App\Api\Transformer\Backend;


use App\City;
use App\Collection;
use app\Repository\DbCollectionRepository;
use app\Repository\DbPhotoRepository;
use Carbon\Carbon;
use jDateTime;
use League\Fractal\TransformerAbstract;

class CollectionTransformer extends TransformerAbstract {


	protected $collectionRepository;

	public function transform(Collection $collection)
	{
		return [
			'name' => $collection->name,
			'description' => $collection->description,
			'type' => $collection->type,
			'slug' => $collection->slug,
			'active' => $collection->active,
			'starts_at' => $collection->starts_at->timestamp,
			'ends_at' => $collection->ends_at->timestamp
		];
	}
}