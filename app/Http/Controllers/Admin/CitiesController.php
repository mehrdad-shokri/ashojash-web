<?php

	namespace App\Http\Controllers\Admin;

	use App\Commands\CreateCityCommand;
	use App\Http\Controllers\Controller;
	use App\Http\Requests;
	use App\Http\Requests\CreateCityRequest;
	use App\Http\Requests\ImageUploadRequest;
	use app\Repository\CityRepository;
	use app\Repository\CuisineRepository;
	use FileUploader;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;

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

		public function all()
		{
			$with = ['photo', 'locations'];
			$availableCities = $this->cityRepository->all($with)->paginate(5);

			return view('admin.cities.all', compact('availableCities'));
		}


		public function create()
		{

			return view('admin.cities.create');
		}

		public function store(CreateCityRequest $request)
		{
			$city = $this->dispatch(new CreateCityCommand($request));
			flash()->success('Success', 'City created Successfully');

			return redirect()->action('Admin\CitiesController@show', $city->slug);
		}

		public function update(Request $request, $citySlug)
		{
			$this->validate($request, [
				'name' => 'required',
				'lat'  => 'required',
				'lng'  => 'required'

			]);
			$city = $this->cityRepository->findBySlugOrFail($citySlug);
			$city->name = $request->get("name");
			$city->lat = $request->get("lat");
			$city->lng = $request->get("lng");
			$city->save();
			flash()->success(trans("modals.finish"), trans("modals.data_saved"));

			return redirect()->back();
		}

		public function show($slug)
		{
			$city = $this->cityRepository->findBySlugOrFail($slug);

			return view('admin.cities.show', compact('city'));
		}

		public function addCityPhoto(ImageUploadRequest $request, $citySlug)
		{
			$city = $this->cityRepository->findBySlugOrFail($citySlug);
			$file = $request->file('file');
			FileUploader::uploadFile($city, $file, Auth::user(), true);

			return response(200);
		}

		public function toggleStatus(Request $request, $cityId)
		{
			if ($request->ajax())
			{
				$city = $this->cityRepository->findById($cityId);
				$city->status == 0 ? $city->status = 1 : $city->status = 0;
				$city->save();

				return response(200);
			}
			abort(500);
		}

	}
