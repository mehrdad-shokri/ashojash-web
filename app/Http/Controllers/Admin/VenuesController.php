<?php

namespace App\Http\Controllers\Admin;

use App\Cuisine;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\AddPlaceRequest;
use App\Http\Requests\AddVenueRequestAsAdmin;
use app\Repository\CityRepository;
use app\Repository\CountryRepository;
use app\Repository\LocationRepository;
use app\Repository\UserRepository;
use app\Repository\VenueRepository;
use App\Tag;
use App\Venue;
use FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class VenuesController extends Controller {

	/**
	 * @var VenueRepository
	 */
	private $venueRepository;
	/**
	 * @var UserRepository
	 */
	private $userRepository;
	/**
	 * @var CityRepository
	 */
	private $cityRepository;
	/**
	 * @var CountryRepository
	 */
	private $countryRepository;
	/**
	 * @var LocationRepository
	 */
	private $locationRepository;


	/**
	 * VenuesController constructor.
	 * @param VenueRepository $venueRepository
	 * @param UserRepository $userRepository
	 * @param CityRepository $cityRepository
	 * @param CountryRepository $countryRepository
	 * @param LocationRepository $locationRepository
	 */
	public function __construct(VenueRepository $venueRepository, UserRepository $userRepository, CityRepository $cityRepository, CountryRepository $countryRepository, LocationRepository $locationRepository)
	{
		$this->venueRepository = $venueRepository;
		$this->userRepository = $userRepository;
		$this->cityRepository = $cityRepository;
		$this->countryRepository = $countryRepository;
		$this->locationRepository = $locationRepository;
	}

	public function create()
	{
		$availableCities = $this->cityRepository->all();

		return view('admin.venues.add-place', compact('availableCities'));
	}

	public function store(AddVenueRequestAsAdmin $request)
	{
		$country = $this->countryRepository->first();
		$vLat = $request->get('lat');
		$vLng = $request->get('lng');
		$venue = $this->venueRepository->create($request->get('name'), null, 1);
		$this->locationRepository->create($venue, $request->get('address'), $request->get('city'), $country->getKey(), $vLat, $vLng);
		flash()->success(trans('modals.finish'), trans('modals.place_added_successfully'));
		return redirect()->back();
	}

	public function all()
	{
		$array = ['location', 'location.city'];
		$venues = $this->venueRepository->all($array)->paginate(15);

		return view('admin.venues.all', compact('venues'));
	}

	public function pending()
	{
		$array = ['location', 'location.city'];
		$venues = $this->venueRepository->all($array)->pending()->paginate(5);

		return view('admin.venues.all', compact('venues'));
	}

	public function show($venueSlug)
	{
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$photosCount = $venue->photos->count();
		$photos = $venue->photos()->take(10)->get();
		$menus = $venue->menus;
		$reviews = $venue->reviews()->with('user')->latest()->simplePaginate(10);
		$currentDay = date('w');
		$currentDaySchedules = $venue->schedules()->orderBy('opening_at')->where('day', $currentDay)->get();
		$schedules = [];
		for ($i = 0; $i < 6; $i++)
			$schedules[$i] = $venue->schedules()->where('day', $i)->get();
		$schedules = $venue->schedules;
		$selectedCuisines = $venue->cuisines->lists('id')->toArray();
		$cuisines = Cuisine::lists('name', 'id')->toArray();
		$selectedTags = $venue->tags->lists('id')->toArray();
		$tags = Tag::lists('name', 'id')->toArray();

		return view('admin.venues.show', compact('venue', 'cuisines', 'selectedCuisines', 'selectedTags', 'tags', 'venue', 'menus', 'photos', 'photosCount', 'reviews', 'currentDaySchedules', 'schedules'));
	}

	public function update(Request $request, $venueSlug)
	{
		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
		$cuisines = $request->get('cuisine_list');
		$tags = $request->get('tag_list');
		if ($cuisines)
			$venue->cuisines()->sync($cuisines);
		else
			$venue->cuisines()->sync([]);
		if ($tags)
			$venue->tags()->sync($tags);
		else
			$venue->tags()->sync([]);

		return redirect()->action('Owner\VenuesController@show', $venueSlug);
	}

	public function manage()
	{

	}

	public function assignUser(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email',
			'venueId' => 'required|integer'
		]);
		$venue = $this->venueRepository->findById($request->get('venueId'));
		$user = $this->userRepository->findByPrimaryEmail($request->get('email'));
		$venue->assignUserByid($user->getKey());
		flash()->success("success", "Users assigned as venueOwner");

		return redirect()->back();
	}

	public function changeStatus(Request $request)
	{
		$this->validate($request, [
			'venueStatus' => 'required|integer|min:0|max:4'
		]);
		$venue = $this->venueRepository->findById($request->get('venueId'));
		$venue->status = $request->get('venueStatus');
		$venue->save();
		flash()->success("success", "Venue status changes");

		return redirect()->back();
	}

	public function json($venueSlug)
	{

		$venue = $this->venueRepository->findBySlugOrFail($venueSlug);

		return view('admin.venues.json', compact('venue'));
	}

	public function uploadPhotos(Request $request, $venueSlug)
	{
		$this->validate($request, [
			'id' => 'required'
		]);
		$user = Auth::user();
		$limit = 200;
		$offset = 0;
		$id = $request->get('id');
		while (true)
		{
			$url = "https://api.foursquare.com/v2/venues/$id/photos?client_id=PNQTT122LIF04JOCHN1H5BQHFZJTJ2OJ51EHZRK3DWFI4JCC&client_secret=5G4WWZWMCOCMWR33U5HZPD2ROAIFPJJ1NBOFV0WOGWVQUKRM&v=20140806&limit=$limit&offset=$offset";
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$jsonData = json_decode($this->getByCurl($url));
			$response = $jsonData->response->photos;
			$photoCount = $response->count;
			if ($photoCount == 0)
			{
				break;
			}
			else
			{
				$photos = $response->items;
				foreach ($photos as $photo)
				{
					try
					{
						$photoUrl = $photo->prefix . "original" . $photo->suffix;
						$photoPath = "../storage/" . str_replace('/', '', $photo->suffix);
						$img = Image::make($photoUrl);
						$img->save($photoPath);
						$uploadedFile = new UploadedFile($photoPath, $photoPath, $img->mime);
						FileUploader::uploadFile($venue, $uploadedFile, $user);
						File::delete($photoPath);
					} catch (NotReadableException $e)
					{
						Log::info($e->getMessage());
					} catch (BadRequestHttpException $e)
					{
						Log::info($e->getMessage());
					}
				}
				$offset += 200;
			}
		}

		flash()->overlay(trans('modals.finish'), "All $photoCount photos uploaded master!");
		return redirect()->back();
	}

	private function getByCurl($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		$data = curl_exec($curl);
		curl_close($curl);
		return $data;
	}

	public function updateVenuesMainPhoto()
	{
		$venues = Venue::all();
		foreach ($venues as $venue)
		{
			$photo = $venue->photos()->first();
			if (!($venue->hasMainImg() || is_null($photo)))
			{
				$venue->image_id = $photo->getKey();
				$venue->save();
			}
		}
	}
}
