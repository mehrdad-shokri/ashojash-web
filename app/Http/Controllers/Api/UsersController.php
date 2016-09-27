<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Requests\ImageUploadRequest;
use app\Repository\ReviewRepository;
use app\Repository\UserRepository;
use app\Repository\VenueRepository;
use app\Transformers\UserTransformer;
use FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UsersController extends ApiController {

	protected $userRepository;
	private $userTransformer;
	/**
	 * @var ReviewRepository
	 */
	private $reviewRepository;
	/**
	 * @var VenueRepository
	 */
	private $venueRepository;

	/**
	 * UsersController constructor.
	 * @param UserRepository $userRepository
	 * @param UserTransformer $userTransformer
	 * @param ReviewRepository $reviewRepository
	 * @param VenueRepository $venueRepository
	 */
	public function __construct(UserRepository $userRepository, UserTransformer $userTransformer, ReviewRepository $reviewRepository, VenueRepository $venueRepository)
	{
		$this->userRepository = $userRepository;
		$this->userTransformer = $userTransformer;
		$this->reviewRepository = $reviewRepository;
		$this->venueRepository = $venueRepository;
	}

	public function addReview(Request $request)
	{
		$validation = Validator::make($request->all(), [
			'comment' => 'required|min:35',
			'decor' => 'required|integer|min:1|max:5',
			'cost' => 'required|integer|min:1|max:5',
			'quality' => 'required|integer|min:1|max:5',
			'slug' => 'required|exists:venues,slug'
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validation->errors());
		}
		$user = Auth::user();
		$decor = $request->get('decor');
		$quality = $request->get('quality');
		$cost = $request->get('cost');
		$comment = $request->get('comment');
		$venue = $this->venueRepository->findBySlugOrFail($request->get('slug'));
		if ($this->reviewRepository->userVenueHasPassedSevenDays($user, $venue))
		{
			$this->reviewRepository->create($user, $venue, $decor, $quality, $cost, $comment);
			return $this->response(['data' => ['review-added' => true]]);
		}
		else
		{
			return $this->setStatusCode(422)->respondWithError(trans("modals.review_limit_exceed"));
		}
	}


	public function addVenuePhoto(Request $request, $venueSlug)
	{
		$user = Auth::user();
		$validation = Validator::make($request->file(), [
			'file' => 'required|MAX:5000|mimes:jpg,jpeg,png'
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validation->errors());
		}
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$file = $request->file('file');
		FileUploader::uploadFile($venue, $file, $user);
		return $this->response(['data' => ['uploaded' => true]]);
	}

	public function addVenuePhotos(Request $request, $venueSlug)
	{
		$user = Auth::user();
		$validation = Validator::make($request->file(), [
			'file' => 'required|MAX:5000|mimes:jpg,jpeg,png'
		]);
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validation->errors());
		}
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$files = $request->files;
		$fileCount = count($files);
		$uploadedFiles = 0;
		foreach ($files as $file)
		{
			FileUploader::uploadFile($venue, $file, $user);
			$uploadedFiles++;
		}
		if ($fileCount == $uploadedFiles)
			return $this->response(['data' => ['uploaded' => true]]);
		else
		{

		}
		if ($validation->fails())
		{
			return $this->setStatusCode(422)->respondWithError($validation->errors());
		}
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$file = $request->file('file');
		FileUploader::uploadFile($venue, $file, $user);
		return $this->response(['data' => ['uploaded' => true]]);
	}
}