<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\VenueClaimRequest;
use app\Repository\CityRepository;
use app\Repository\MenuRepository;
use app\Repository\PhotoRepository;
use app\Repository\ReviewRepository;
use app\Repository\VenueRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VenuesController extends Controller {

	/**
	 * @var VenueRepository
	 */
	private $venueRepository;
	/**
	 * @var PhotoRepository
	 */
	private $photoRepository;
	/**
	 * @var ReviewRepository
	 */
	private $reviewRepository;
	/**
	 * @var CityRepository
	 */
	private $cityRepository;
	/**
	 * @var MenuRepository
	 */
	private $menuRepository;


	/**
	 * VenuesController constructor.
	 * @param VenueRepository $venueRepository
	 * @param PhotoRepository $photoRepository
	 * @param ReviewRepository $reviewRepository
	 * @param CityRepository $cityRepository
	 * @param MenuRepository $menuRepository
	 */
	public function __construct(VenueRepository $venueRepository, PhotoRepository $photoRepository, ReviewRepository $reviewRepository, CityRepository $cityRepository, MenuRepository $menuRepository)
	{
		Carbon::setLocale('fa');
		$this->venueRepository = $venueRepository;
		$this->photoRepository = $photoRepository;
		$this->reviewRepository = $reviewRepository;
		$this->cityRepository = $cityRepository;
		$this->menuRepository = $menuRepository;
	}

	public function show($venueSlug)
	{
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$photosCount = $this->photoRepository->venuePhotosCount($venue);
		$photos = $this->photoRepository->venuePhotos($venue);
		$menus = $this->menuRepository->menus($venue);
		$reviews = $this->reviewRepository->venueReviewsSimplePaginated($venue, 10);
		$currentDay = date('w');

		$currentDaySchedules = Cache::remember($venueSlug . "current_day_schedules", 20, function () use ($venue, $currentDay)
		{
			return $this->venueRepository->currentDaySchedule($venue);
		});
		$schedules = Cache::remember($venueSlug . "schedules", 20, function () use ($venue)
		{
			return $this->venueRepository->schedules($venue);
		});

		return view('venues.show', compact('venue', 'menus', 'photos', 'photosCount', 'reviews', 'currentDaySchedules', 'schedules'));
	}

	public function menu($slug)
	{
		$venue = $this->venueRepository->findBySlugOrFail($slug);
		$menus = Cache::remember($slug . "menu", 20, function () use ($venue)
		{
			return $this->menuRepository->menus($venue);
		});

		return view('venues.menu', compact('venue', 'menus', 'photosCount'));
	}

	public function photos($slug)
	{
		$venue = $this->venueRepository->findBySlugOrFail($slug);
		$photos = Cache::remember($slug . "photos", 10, function () use ($venue)
		{
			return $this->photoRepository->venuePhotos($venue);
		});

		return view('venues.photos', compact('venue', 'photos'));
	}

	public function postClaim(VenueClaimRequest $request)
	{

		return redirect()->action("VenuesController@getClaim", array($request->get("city-slug"), $request->get("venue-slug")));

	}

	public function getClaim($citySlug, $venueSlug)
	{
		try
		{
			$city = $this->cityRepository->findBySlugOrFail($citySlug);
			$venue = $this->venueRepository->whereCity($venueSlug, $city);

			return view('payments.claim', compact('venue'));
		} catch (ModelNotFoundException $e)
		{
			flash()->overlay(trans("modals.error"), trans("modals.venue_claim_not_found"), 'warning');

			return redirect()->back();
		}
	}

}
