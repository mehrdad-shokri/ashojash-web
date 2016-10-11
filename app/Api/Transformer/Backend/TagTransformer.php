<?php

namespace App\Api\Transformer\Backend;


use App\City;
use App\Collection;
use app\Repository\DbCollectionRepository;
use app\Repository\DbPhotoRepository;
use App\Tag;
use Carbon\Carbon;
use jDateTime;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract {

	public function transform(Tag $tag)
	{
		return [
			'name' => $tag->name,
			'level' => $tag->level
		];
	}
}