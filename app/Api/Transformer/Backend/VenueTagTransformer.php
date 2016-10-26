<?php

namespace App\Api\Transformer\Backend;


use App\Api\Transformer\SimplePhotoTransformer;
use app\Repository\DbPhotoRepository;
use App\Tag;
use League\Fractal\TransformerAbstract;
use Vinkla\Hashids\Facades\Hashids;

class VenueTagTransformer extends TransformerAbstract {

	public function transform(Tag $tag)
	{
		return [
			'id' => Hashids::encode($tag->id),
			'name' => $tag->name,
			'weight' => $tag->pivot->weight
		];
	}
}