<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use app\Repository\CityRepository;
use app\Repository\CountryRepository;
use app\Repository\LocationRepository;
use app\Repository\VenueRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller {

	/**
	 * @var CityRepository
	 */
	private $cityRepository;
	/**
	 * @var VenueRepository
	 */
	private $venueRepository;
	/**
	 * @var LocationRepository
	 */
	private $locationRepository;

	/**
	 * PagesController constructor.
	 * @param CityRepository $cityRepository
	 * @param VenueRepository $venueRepository
	 * @param LocationRepository $locationRepository
	 */
	public function __construct(CityRepository $cityRepository, VenueRepository $venueRepository, LocationRepository $locationRepository)
	{
		$this->cityRepository = $cityRepository;
		$this->venueRepository = $venueRepository;
		$this->locationRepository = $locationRepository;
	}

	public function home(Request $request)
	{
		$cityCookie = $request->cookie('exp_current_city');
		if ($cityCookie)
			return redirect()->action('CitiesController@index', $cityCookie);
		else
		{
			Cache::remember('first_page_cities', 60, function ()
			{
				return $this->cityRepository->available();
			});
			$cities = Cache::get("first_page_cities");
			return view('pages.home', compact('cities'));
		}
	}
}
