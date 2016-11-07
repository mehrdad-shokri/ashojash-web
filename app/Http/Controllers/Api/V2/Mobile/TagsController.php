<?php

namespace App\Http\Controllers\Api\V2\Mobile;


use App\Api\Transformer\TagTransformer;
use App\Http\Controllers\Api\v2\BaseController;
use app\Repository\TagRepository;

class TagsController extends BaseController {

	/**
	 * @var TagRepository
	 */
	private $tagRepository;


	/**
	 * TagsController constructor.
	 * @param TagRepository $tagRepository
	 */
	public function __construct(TagRepository $tagRepository)
	{
		$this->tagRepository = $tagRepository;
	}

	public function suggestions()
	{
		return $this->response->collection($this->tagRepository->topLevels(), new TagTransformer());
	}
}