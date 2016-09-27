<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Collection;
use app\Repository\CityRepository;
use app\Repository\CollectionRepository;
use Carbon\Carbon;
use FileUploader;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CollectionsController extends Controller {

	/**
	 * @var CollectionRepository
	 */
	private $collectionRepository;
	/**
	 * @var CityRepository
	 */
	private $cityRepository;

	/**
	 * CollectionsController constructor.
	 * @param CollectionRepository $collectionRepository
	 * @param CityRepository $cityRepository
	 */
	public function __construct(CollectionRepository $collectionRepository, CityRepository $cityRepository)
	{
		$this->collectionRepository = $collectionRepository;
		$this->cityRepository = $cityRepository;
	}

	public function all()
	{
		$collections = $this->collectionRepository->allPaginated(10);
		return view('content-provider.collections.all', compact('collections'));
	}

	public function create()
	{
		$types = Collection::$types;
		$availableCities = $this->cityRepository->available();
		return view('content-provider.collections.create', compact('types', 'availableCities'));
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => 'required |unique:collections,name|max:100',
			'price' => 'integer|max:4000000|min:0',
			'description' => 'string|max:255',
			'type' => 'required',
			'cityId' => 'exists:cities,id',
			'date' => 'required|date',
		]);
		$cityId = ($request->get("cityId") == "") ? null : $request->get("cityId");
		$this->collectionRepository->create($request->get('name'), $request->get('description'), $request->get('price'), $request->get('type'), $cityId, $request->get('date'));
		flash()->success(trans('modals.finish'), trans('modals.item_added'));
		return redirect()->back();
	}

	public function show($slug)
	{
		$collection = $this->collectionRepository->findBySlugOrFail($slug);
		return view('content-provider.collections.show', compact('collection'));
	}

	public function update()
	{
	}

	public function delete()
	{
	}

	public function addPhoto(Request $request, $slug)
	{
		$collection = $this->collectionRepository->findBySlugOrFail($slug);
		$file = $request->file('file');
		FileUploader::uploadFile($collection, $file, Auth::user(), true);

		return response(200);
	}
}
