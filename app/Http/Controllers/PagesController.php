<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPlaceRequest;
use app\Repository\CityRepository;
use app\Repository\CountryRepository;
use app\Repository\LocationRepository;
use app\Repository\VenueRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PagesController extends Controller
{

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
     * @var CountryRepository
     */
    private $countryRepository;

    /**
     * PagesController constructor.
     * @param CityRepository $cityRepository
     * @param CountryRepository $countryRepository
     * @param VenueRepository $venueRepository
     * @param LocationRepository $locationRepository
     */
    public function __construct(CityRepository $cityRepository,CountryRepository $countryRepository, VenueRepository $venueRepository, LocationRepository $locationRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->venueRepository = $venueRepository;
        $this->locationRepository = $locationRepository;
        $this->countryRepository = $countryRepository;
    }

    public function home()
    {
        $cityCookie = Cookie::get('exp_current_city');
        if ($cityCookie) {
            return redirect()->action('CitiesController@index', $cityCookie);
        } else {
            $cities = $this->cityRepository->available();
            return view('pages.home', compact('cities'));
        }
    }

    public function about()
    {
        return view('pages.about');
    }

    public function businessOwners()
    {
        return view('pages.biz-owner');
    }

    public function addPlace()
    {
        $availableCities = $this->cityRepository->available();

        return view('pages.add-place', compact('availableCities'));
    }

    public function storePlace(AddPlaceRequest $request)
    {
        $country = $this->countryRepository->first();
        $vLat = $request->has('v-lat') ? $request->get('v-lat') : 0;
        $vLng = $request->has('v-lng') ? $request->get('v-lng') : 0;
        $venue = $this->venueRepository->create($request->get('name'), $request->get('phone'));
        $this->locationRepository->create($venue, $request->get('address'), $request->get('city'), $country->getKey(), $vLat, $vLng);

        flash()->success(trans('modals.finish'), trans('modals.place_added_successfully'));

        return redirect()->back();
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function storeContact(ContactUsRequest $request, ContactMailer $mailer)
    {
        $mailer->contactUs($request->get('name'), $request->get('email'), $request->get('tel'), $request->get('message'));

        flash()->success(trans('modals.finish'), trans("modals.contact_soon"));

        return redirect()->back();
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function guidelines()
    {
        return view('pages.guidelines');
    }

    public function policies()
    {
        return view('pages.policies');
    }

    public function cookiePolicy()
    {
        return view('pages.cookie-policy');
    }

    public function feedback(Request $request)
    {
        if ($request->ajax())
        {
            Feedback::create(['message' => $request->get('message')]);
            $cookie = cookie("ashojash_feedback", 1, 20160);
            Cookie::queue($cookie);

            return response('', 200);
        }
        throw new BadRequestHttpException();
    }
}
