<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use app\Repository\CityRepository;
use app\Repository\CollectionRepository;
use app\Repository\CuisineRepository;
use app\Repository\PhotoRepository;
use app\Repository\UserRepository;
use app\Repository\VenueRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PhotosController extends Controller {

	/**
	 * @var CityRepository
	 */
	private $cityRepository;
	/**
	 * @var VenueRepository
	 */
	private $venueRepository;
	/**
	 * @var PhotoRepository
	 */
	private $photoRepository;
	/**
	 * @var UserRepository
	 */
	private $userRepository;
	/**
	 * @var CuisineRepository
	 */
	private $cuisineRepository;
	/**
	 * @var CollectionRepository
	 */
	private $collectionRepository;


	/**
	 * PhotosController constructor.
	 * @param CityRepository $cityRepository
	 * @param VenueRepository $venueRepository
	 * @param PhotoRepository $photoRepository
	 * @param UserRepository $userRepository
	 * @param CuisineRepository $cuisineRepository
	 * @param CollectionRepository $collectionRepository
	 */
	public function __construct(CityRepository $cityRepository, VenueRepository $venueRepository, PhotoRepository $photoRepository, UserRepository $userRepository, CuisineRepository $cuisineRepository, CollectionRepository $collectionRepository)
	{
		$this->cityRepository = $cityRepository;
		$this->venueRepository = $venueRepository;
		$this->photoRepository = $photoRepository;
		$this->userRepository = $userRepository;
		$this->cuisineRepository = $cuisineRepository;
		$this->collectionRepository = $collectionRepository;
	}

	public function getCityPhoto(Request $request, $citySlug)
	{
		$width = $request->get('w');
		$city = $this->cityRepository->findBySlugOrFail($citySlug);
		$entry = $this->photoRepository->cityPhoto($city);
//			$file = (is_null($entry)) ? Storage::disk('local')->get("static/blur.jpg") : Storage::disk('local')->get($entry->path);
		$file = Storage::disk('local')->get($entry->path);
		$image = Image::make($file);
		if (!is_null($width))
		{
			$image->resize($width, null, function ($constraint)
			{
				$constraint->aspectRatio();
			});
		}

		return $image->response();
	}

	public function getVenuePhoto(Request $request, $venueSlug)
	{
		$width = $request->get('w');
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$entry = $this->photoRepository->venueMainPhoto($venue);
		$file = Storage::disk('local')->get($entry->path);
		$image = Image::make($file);
		if (!is_null($width))
		{
			$image->resize($width, null, function ($constraint)
			{
				$constraint->aspectRatio();
			});
		}

		return $image->response();
	}

	public function getUserAvatar(Request $request, $username)
	{
		$width = $request->get('w');
		$user = $this->userRepository->findByUsername($username);
		$entry = $this->photoRepository->userAvatar($user);
		$file = Storage::disk('local')->get($entry->path);
		$image = Image::make($file);
		if (!is_null($width))
		{
			$image->resize($width, null, function ($constraint)
			{
				$constraint->aspectRatio();
			});
		}

		return $image->response();
	}

	public function getPhotoByFilename(Request $request, $filename)
	{
		$width = $request->get('w');
		$entry = $this->photoRepository->filename($filename);
		$file = Storage::disk('local')->get($entry->path);
		$image = Image::make($file);
		if (!is_null($width))
		{
			$image->resize($width, null, function ($constraint)
			{
				$constraint->aspectRatio();
			});
		}

		return $image->response();
	}

	public function getCuisinePhoto(Request $request, $cuisineSlug)
	{
		$width = $request->get('w');
		$cuisine = $this->cuisineRepository->findBySlug($cuisineSlug);
		$entry = $this->photoRepository->cuisinePhoto($cuisine);

		$file = Storage::disk('local')->get($entry->path);
		$image = Image::make($file);
		if (!is_null($width))
		{
			$image->resize(null, $width, function ($constraint)
			{
				$constraint->aspectRatio();
			});
		}
		return $image->response();
	}

	public function getCollectionPhoto(Request $request, $collectionSlug)
	{
		$width = $request->get('w');
		$cuisine = $this->collectionRepository->findBySlugOrFail($collectionSlug);
		$entry = $this->photoRepository->collectionPhoto($cuisine);

		$file = Storage::disk('local')->get($entry->path);
		$image = Image::make($file);
		if (!is_null($width))
		{
			$image->resize(null, $width, function ($constraint)
			{
				$constraint->aspectRatio();
			});
		}
		return $image->response();
	}
}
