<?php

	namespace App\Http\Controllers;

	use App\City;
	use App\Venue;
	use Illuminate\Http\Request;

	use App\Http\Requests;

	class SearchesController extends Controller {

		public function searchVenue(Request $request, $venueName)
		{
			if ($request->ajax())
			{
				try
				{
					$venues = Venue::available()->select('name', 'slug');
					$venues->where('name', 'like', '%' . $venueName . '%');

					return response()->json($venues->get());
				} catch (ModelNotFoundException $e)
				{
					abort(500);
				}
			}
			abort(500);
		}

		public function searchCity(Request $request, $cityName)
		{
			if ($request->ajax())
			{
				try
				{
					$cities = City::available()->select('name', 'slug');
					$cities->where('name', 'like', '%' . $cityName . '%');

					return response()->json($cities->get());
				} catch (ModelNotFoundException $e)
				{
					abort(500);
				}
			}
			abort(500);
		}
	}
