<?php

namespace App\Api\Transformer;


use app\Repository\DbPhotoRepository;
use App\Tag;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract {

	protected $defaultIncludes = ['photo'];
	private $photoRepository;

	public function __construct()
	{
		$this->photoRepository = new DbPhotoRepository();
	}

	public function transform(Tag $tag)
	{
		return [
			'name' => $tag->name,
			'level' => $tag->level
		];
	}

	public function includePhoto(Tag $tag)
	{
		$photo = $this->photoRepository->tagPhoto($tag);
		if ($photo)
			return $this->item($photo, new SimplePhotoTransformer());
		return null;
	}
}