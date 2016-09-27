<?php

	namespace App\Http\Controllers\BusinessOwner;

	use App\Commands\BusinessOwnerSuggestionCommand;
	use App\Commands\BusinessOwnerSupportCommand;
	use App\Http\Controllers\Controller;
	use App\Http\Requests;
	use App\Http\Requests\ImageUploadRequest;
	use App\Http\Requests\ScheduleRequest;
	use app\Repository\ReviewRepository;
	use app\Repository\UserRepository;
	use app\Repository\VenueRepository;
	use App\Venue;
	use FileUploader;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Cache;
	use Illuminate\Support\Facades\Log;

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
		 * @var ReviewRepository
		 */
		private $reviewRepository;


		/**
		 * VenuesController constructor.
		 * @param VenueRepository $venueRepository
		 * @param ReviewRepository $reviewRepository
		 */
		public function __construct(VenueRepository $venueRepository, ReviewRepository $reviewRepository
		)
		{
			$this->venueRepository = $venueRepository;
			$this->reviewRepository = $reviewRepository;
		}

		public function info($venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);

			return view('biz-owner.venues.info', compact('venue'));
		}

		public function reviews($venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$reviews = $this->reviewRepository->venueReviews($venue);

			return view('biz-owner.venues.reviews', compact('venue', 'reviews'));

		}

		public function reportReview(Request $request, $venueSlug, $commentId)
		{
			if ($request->ajax())
			{
				$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
				$review = $this->reviewRepository->findReviewById($venue, $commentId);
				$review->status == 0 ? $review->status = 1 : $review->status = 0;
				$review->save();

				return response(200);

			}
			abort(500);

		}

		public function support($venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);

			return view('biz-owner.venues.support', compact('venue'));
		}

		public function storeSupport(Request $request, $venueSlug)
		{
			$this->validate($request, [
				'subject' => 'required',
				'message' => 'required'
			]);
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$this->dispatch(new BusinessOwnerSupportCommand($request, $venue));
			flash()->success(trans("modals.finish"), trans("modals.contact_soon"));

			return redirect()->back();
		}

		public function storeSuggestion(Request $request, $venueSlug)
		{
			$this->validate($request, [
				'subject' => 'required',
				'message' => 'required'
			]);
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$this->dispatch(new BusinessOwnerSuggestionCommand($request, $venue));
			flash()->success(trans("modals.finish"), trans("modals.contact_soon"));

			return redirect()->back();
		}

		/*	public function addVenueMainPhoto(Request $request, $venueSlug)
			{
				$file = $request->file('file');
				$venue = Venue::findBySlugOrFail($venueSlug);
				FileUploader::uploadFile($venue, $file);
			}*/

		public function suggestion($venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);

			return view('biz-owner.venues.suggestion', compact('venue'));
		}

		public function schedules($venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$schedules = $venue->schedules()->orderBy("day")->get();

//				$schedules[] = $venue->schedules()->where("day", "<", 6)->get()->sortBy('day');

			return view('biz-owner.venues.schedules', compact('venue', 'schedules'));
		}

		public function storeSchedule(ScheduleRequest $request, $venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$count = count($request->get('clockPickerFrom'));
			$venue->schedules()->delete();
			for ($i = 0; $i < $count; $i++)
			{
				$opening_at = $request->get("clockPickerFrom")[$i];
				$closing_at = $request->get("clockPickerTo")[$i];
				$day = $request->get("day")[$i];
				$venue->schedules()->create(['opening_at' => $opening_at, 'closing_at' => $closing_at, 'day' => $day]);
			}
			flash()->success(trans("modals.finish"), trans("modals.data_saved"));

			return redirect()->back();
		}

		public function getPhoto($venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);

			return view('biz-owner.venues.photo', compact('venue'));
		}

		public function getMap($venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$lat = null;
			$lng = null;
			$zoom = null;

			if (($venue->location->lat) && ($venue->location->lng))
			{
				$lat = $venue->location->lat;
				$lng = $venue->location->lng;
				$zoom = 17;
			}
			else
			{
				$lat = $venue->city()->lat;
				$lng = $venue->city()->lng;
				$zoom = 13;
			}

			return view('biz-owner.venues.map', compact('venue', 'lat', 'lng', 'zoom'));
		}

		public function postMap(Request $request, $venueSlug)
		{
			$this->validate($request, [
				'v-lat' => 'required|numeric',
				'v-lng' => 'required|numeric'
			]);
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$venue->location->lat = $request->get('v-lat');
			$venue->location->lng = $request->get('v-lng');
			$venue->location->save();
			flash()->success(trans("modals.finish"), trans("modals.data_saved"));

			return redirect()->back();

		}


		public function postPhoto(ImageUploadRequest $request, $venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$file = $request->file('file');
			FileUploader::uploadFile($venue, $file, Auth::user(), true);

			return response(200);
		}

	}
