<?php

	namespace App\Http\Controllers;

	use App\Cuisine;
	use App\Http\Requests;
	use app\Repository\CityRepository;
	use app\Repository\CuisineRepository;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Support\Facades\Cache;
	use Illuminate\Support\Facades\Cookie;

	class CitiesController extends Controller {

		/**
		 * @var CityRepository
		 */
		private $cityRepository;
		/**
		 * @var CuisineRepository
		 */
		private $cuisineRepository;


		/**
		 * CitiesController constructor.
		 * @param CityRepository $cityRepository
		 * @param CuisineRepository $cuisineRepository
		 */
		public function __construct(CityRepository $cityRepository, CuisineRepository $cuisineRepository)
		{
			$this->cityRepository = $cityRepository;
			$this->cuisineRepository = $cuisineRepository;
		}

		public function index($citySlug)
		{
			try
			{
				$city = $this->cityRepository->findBySlugOrFail($citySlug);
				$cookie = cookie()->forever('exp_current_city', $citySlug);
				Cookie::queue($cookie);
				$cuisines = Cache::remember($citySlug . "first_page_cuisines", 50, function ()
				{
					$cuisines = [];
					foreach (Cuisine::firstPage()->get() as $cuisine)
						$cuisines[] = $cuisine;

					return $cuisines;
				});

				$venuesLists = Cache::remember($citySlug . "top_venues_cuisine3", 50, function () use ($cuisines, $city)
				{
					$venuesLists = [];
					foreach ($cuisines as $cuisine)
						$venuesLists[] = $city->takeTopVenuesByCuisineSlug($cuisine->slug)->orderBy("score", "desc")->take(3)->get();

					return $venuesLists;
				});

				return view('cities.show', compact('city', 'venuesLists', 'cuisines'));
			} catch (ModelNotFoundException $e)
			{
				$cookie = Cookie::forget("exp_current_city");

				return redirect()->action('PagesController@home')->withCookie($cookie);
			}
		}


		public function setCity($citySlug)
		{
			$this->cityRepository->findBySlugOrFail($citySlug);
			$cookie = cookie()->forever('exp_current_city', $citySlug);

			return redirect()->action('CitiesController@index', $citySlug)->withCookie($cookie);
		}

		public function allVenuesCuisine($citySlug, $cuisineSlug)
		{
			$city = $this->cityRepository->findBySlugOrFail($citySlug);
			$cuisine = $this->cuisineRepository->findBySlug($cuisineSlug);
			$venues = $this->cuisineRepository->venuesByCuisineSlug($city,$cuisineSlug)->simplePaginate(20);

			return view('cuisines.category', compact('city', 'venues', 'cuisine'));
		}

		public function allCuisines($citySlug)
		{
			$this->cityRepository->findBySlugOrFail($citySlug);
			$cuisines = $this->cuisineRepository->simplePaginate(10);
			$cuisines->map(function ($cuisine)
			{
				$cuisine->venues = $this->cuisineRepository->findBySlug($cuisine->slug)->venues;
			});

			return view('cuisines.all', compact('cuisines'));
		}
	}
