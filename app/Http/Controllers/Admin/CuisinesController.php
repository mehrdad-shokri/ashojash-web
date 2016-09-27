<?php

	namespace App\Http\Controllers\Admin;

	use App\Cuisine;
	use App\Http\Controllers\Controller;
	use App\Http\Requests;
	use App\Http\Requests\ImageUploadRequest;
	use app\Repository\CuisineRepository;
	use FileUploader;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;

	class CuisinesController extends Controller {

		/**
		 * @var CuisineRepository
		 */
		private $cuisineRepository;

		/**
		 * CuisinesController constructor.
		 * @param CuisineRepository $cuisineRepository
		 */
		public function __construct(CuisineRepository $cuisineRepository)
		{
			$this->cuisineRepository = $cuisineRepository;
		}

		public function  all()
		{
			$managedCuisines = Cuisine::paginate(10);

			return view('content-provider.cuisines.all', compact('managedCuisines'));
		}


		public function show($id)
		{
			$cuisine = $this->cuisineRepository->findById($id);

			return view('content-provider.cuisines.show', compact('cuisine'));
		}

		public function create()
		{
			return view('content-provider.cuisines.create');
		}

		public function store(Request $request)
		{
			$this->validate($request, [
				'name' => 'required |unique:cuisines| max:100',
			]);
			$this->cuisineRepository->create($request->name);
			flash()->success('success', 'Cuisine created successfully');

			return redirect()->back();
		}

		public function delete($id)
		{
			$this->cuisineRepository->destroy($id);


			return redirect()->action('ContentProvider\CuisinesController@all');
		}

		public function update(Request $request, $id)
		{
			$this->validate($request, [
				'name' => 'required| max:100',
			]);
			$cuisine = $this->cuisineRepository->findById($id);
			$cuisine->name = $request->get('name');
			$cuisine->motto = $request->get('motto');
			$cuisine->first_page = $request->get("firstPage");
			$cuisine->save();
			flash()->success('success', 'Cuisine updated successfully');

			return redirect()->back();
		}

		public function addCuisinePhoto(ImageUploadRequest $request, $cuisineSlug)
		{
			$cuisine = $this->cuisineRepository->findBySlug($cuisineSlug);
			$file = $request->file('file');
			FileUploader::uploadFile($cuisine, $file, Auth::user(), true);

			return response(200);
		}
	}
