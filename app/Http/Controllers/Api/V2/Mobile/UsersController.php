<?php

namespace App\Http\Controllers\Api\V2\Mobile;

use App\Api\Transformer\ReviewAddedTransformer;
use App\Api\Transformer\UserTransformer;
use App\Http\Controllers\Api\v2\BaseController;
use app\Repository\ReviewRepository;
use app\Repository\UserRepository;
use app\Repository\VenueRepository;
use FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends BaseController {

	/**
	 * @var UserRepository
	 */
	private $userRepository;
	/**
	 * @var UserTransformer
	 */
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
		$comment = $request->get('comment');
		$decor = $request->get('decor');
		$cost = $request->get('cost');
		$quality = $request->get('quality');
		$slug = $request->get('slug');
		$rules = [
			'comment' => 'required|min:70',
			'decor' => 'required|integer|min:1|max:5',
			'cost' => 'required|integer|min:1|max:5',
			'quality' => 'required|integer|min:1|max:5',
			'slug' => 'required|exists:venues,slug'
		];
		$validator = app('validator')->make(compact('comment', 'decor', 'cost', 'quality', 'slug'), $rules);
		if ($validator->fails())
		{
			return $this->response->errorBadRequest("Validation failed");
		}
		$user = Auth::user();
		$venue = $this->venueRepository->findBySlugOrFail($request->get('slug'));
		if ($this->reviewRepository->userVenueHasPassedSevenDays($user, $venue))
		{
			$this->reviewRepository->create($user, $venue, $decor, $quality, $cost, $comment);
			return $this->response->created();
		}
		else
		{
			return $this->response->errorBadRequest(trans("modals.review_limit_exceed"));
		}
	}

	public function addVenuePhoto(Request $request, $venueSlug)
	{
		$file = $request->file('file');
		$rules = [
			'file' => 'required|MAX:5000|mimes:jpg,jpeg,png'
		];
		$validator = app('validator')->make(compact('file'), $rules);
		if ($validator->fails())
		{
			return $this->response->errorBadRequest("Validation failed");
		}
		$user = Auth::user();
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		FileUploader::uploadFile($venue, $file, $user);
		return $this->response->created();
	}
}
