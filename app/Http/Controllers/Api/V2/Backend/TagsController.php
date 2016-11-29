<?php

namespace App\Http\Controllers\Api\V2\Backend;


use App\Api\Transformer\Backend\TagTransformer;
use App\Http\Controllers\Api\v2\BaseController;
use app\Repository\TagRepository;
use FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class TagsController extends BaseController {

	/**
	 * @var TagRepository
	 */
	private $tagRepository;

	public function __construct(TagRepository $tagRepository)
	{
		$this->tagRepository = $tagRepository;
	}

	public function all()
	{
		$tags = $this->tagRepository->all();
		return $this->response->collection($tags, new TagTransformer());
	}

	public function store(Request $request)
	{
		$rules = [
			'name' => 'required|string|unique:tags',
			'level' => 'integer',
		];
		$validator = app('validator')->make($request->all(), $rules, ['name.unique' => $request->get('name') . " قبلا انتخاب شده"]);
		if ($validator->fails())
		{
			$this->response->errorBadRequest($this->errorResponse($validator));
		}
		$this->tagRepository->create($request->get('name'), $request->get('level'));
		return $this->response->created();
	}

	public function addPhoto(Request $request)
	{
		$rules = [
			'id' => 'required|string',
			'file' => 'required|image|max:5000',
		];
		$validator = app('validator')->make($request->all(), $rules);
		if ($validator->fails())
		{
			$this->response->errorBadRequest($this->errorResponse($validator));
		}
		$tag = $this->tagRepository->findByIdOrFail(Hashids::decode($request->get('id'))[0]);
		FileUploader::uploadFile($tag, $request->file('file'), Auth::user(), true);
		$this->response->created();
	}

}