<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\UpdateSettingsRequest;
use app\Repository\CityRepository;
use app\Repository\PhotoRepository;
use app\Repository\ReviewRepository;
use app\Repository\UserRepository;
use app\Repository\VenueRepository;
use Carbon\Carbon;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class UsersController extends Controller
{

    /**
     * @var UsersRepository
     */
    private $userRepository;
    /**
     * @var PhotoRepository
     */
    private $photoRepository;
    /**
     * @var ReviewRepository
     */
    private $reviewRepository;
    /**
     * @var VenueRepository
     */
    private $venueRepository;
    /**
     * @var CityRepository
     */
    private $cityRepository;


    /**
     * UsersController constructor.
     * @param UserRepository $userRepository
     * @param PhotoRepository $photoRepository
     * @param ReviewRepository $reviewRepository
     * @param VenueRepository $venueRepository
     * @param CityRepository $cityRepository
     */
    public function __construct(UserRepository $userRepository, PhotoRepository $photoRepository, ReviewRepository $reviewRepository, VenueRepository $venueRepository,CityRepository $cityRepository)
    {
        $this->userRepository = $userRepository;
        $this->photoRepository = $photoRepository;
        Carbon::setLocale('fa');
        $this->reviewRepository = $reviewRepository;
        $this->venueRepository = $venueRepository;
        $this->cityRepository = $cityRepository;
    }

    public function show($username)
    {
        $user = $this->userRepository->findByUsername($username);
        $followers = $user->followers()->get();
        $photos = $this->photoRepository->userUploadedVenuePhotos($user);
        $feeds = $this->reviewRepository->userFeedSimplePaginated($user);
        return view('users.profile', compact('user', 'followers', 'photos', 'feeds'));
    }

    public function followers($username)
    {
        $user = $this->userRepository->findByUsername($username);
        $followers = $user->followers()->get();
        $follows = $user->follows()->get();
        $photos = $this->photoRepository->userUploadedVenuePhotos($user);
        return view('users.followers', compact('user', 'followers', 'follows', 'photos'));
    }

    public function photos($username)
    {
        $user = $this->userRepository->findByUsername($username);
        $followers = $user->followers()->get();
        $photos = $this->photoRepository->userUploadedVenuePhotos($user);

        return view('users.photos', compact('user', 'followers', 'photos'));
    }

    public function reviews($username)
    {
        $user = $this->userRepository->findByUsername($username);
        $followers = $user->followers()->get();
        $photos = $this->photoRepository->userUploadedVenuePhotos($user);
        $reviews = $this->reviewRepository->userReviewsSimplePaginated($user);

        return view('users.reviews', compact('user', 'followers', 'photos', 'reviews'));
    }

    public function addProfilePhoto(ImageUploadRequest $request)
    {
        $user = Auth::user();
        $file = $request->file('file');
        FileUploader::uploadFile($user, $file, $user);
        if (!$request->ajax()) {
            flash()->success(trans("modals.finish"), trans("modals.file_upload_finished"));
        }

        return redirect()->back();

    }

    public function addVenuePhoto(ImageUploadRequest $request, $venueSlug)
    {
        $user = Auth::user();
        $venue = $this->venueRepository->findBySlugOrFail($venueSlug);
        $files = $request->file('file');
        FileUploader::uploadFile($venue, $files, $user);
        if (!$request->ajax()) {
            flash()->success(trans("modals.finish"), trans("modals.file_upload_finished"));
        }

        return redirect()->back();
    }


    public function addReview(Request $request)
    {
        try {
            if (!$request->ajax()) throw new BadRequestHttpException();
            $dataJson = json_decode($request->get('data'), true);
            $data = [];
            foreach ($dataJson as $key => $value) {
                $data[$key] = $value;
            }
            self::validateInput($data);
            $user = Auth::user();
            $venue = $this->venueRepository->findBySlugOrFail($data["venueSlug"]);
            if ($this->reviewRepository->userVenueHasPassedSevenDays($user, $venue)) {
                $user->reviews()->create(['venue_id' => $venue->getKey(), 'decor' => $data["decor"], 'quality' => $data["quality"], 'cost' => $data["cost"], 'comment' => $data["review-text"]]);

                return response(200);
            }
            abort(429);
        } catch (BadRequestHttpException $e) {
            abort(500);
        }
    }


    public function deleteReview(Request $request, $reviewId)
    {
        try {
            if (!$request->ajax()) throw new BadRequestHttpException();
            $review = Auth::user()->reviews()->where('id', $reviewId)->get();
            if (is_null($review)) abort(500);
            $review->first()->delete();

            return response(200);
        } catch (MethodNotAllowedException $e) {
            abort(500);
        }

    }

    private function validateInput($data)
    {
        try {
            if (!$this->isValid($data['cost']) || !$this->isValid($data['decor']) || !$this->isValid($data['quality']) || !strlen($data['review-text']) > 70 || strlen($data['review-text'] > 65000))
                throw  new InvalidArgumentException();
        } catch (InvalidArgumentException $e) {
            abort(422);
        }
    }

    private function isValid($value)
    {
        return ($value >= 1) && ($value <= 5);
    }

    public function settings()
    {
        $user = Auth::user();
        $followers = $user->followers()->get();
        $photos = $this->photoRepository->userUploadedVenuePhotos($user);
        $availableCities = $this->cityRepository->available();
        return view('users.settings', compact('user', 'followers', 'photos', 'availableCities'));
    }

    public function updateSettings(UpdateSettingsRequest $request)
    {
        $user = Auth::user();
        $city = City::findBySlugOrFail($request->get('city'));
        $user->bio = $request->get('bio');
        $user->phone = $request->get('phone');
        $user->name = $request->get('name');
        $user->city_id = $city->getKey();
        $user->save();
        flash()->success(trans("modals.finish"), trans("modals.data_saved"));

        return redirect()->back();
    }

    public function venues()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $venues = $user->venuesOwned;
        $followers = $user->followers()->get();
        $photos = $this->photoRepository->userUploadedVenuePhotos($user);
        return view('users.venues-owned', compact('venues', 'user', 'followers', 'photos', 'now'));
    }
}
