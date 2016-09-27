<?php namespace App\Http\ViewComposers;


use App\City;
use App\Cuisine;
use app\Repository\CityRepository;
use Illuminate\Auth\Guard;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class GlobalComposer {

	/**
	 * @var CityRepository
	 */
	private $cityRepository;

	/**
	 * @var Guard
	 */
	public function __construct(CityRepository $cityRepository)
	{
		$this->cityRepository = $cityRepository;
	}

	/**
	 * Bind data to the view.
	 *
	 * @param  View $view
	 * @return void
	 */
	public function compose(View $view)
	{
		$view->with('currentUser', Auth::user());
		$view->with('cities', $this->cityRepository->available());
		$view->with('navbarCuisines', Cuisine::all());
		$currentCity = City::where("slug", Cookie::get('exp_current_city', 'thr'))->first();
		if (is_null($currentCity))
			$currentCity = City::first();
		$view->with('currentCity', $currentCity);
	}
}
