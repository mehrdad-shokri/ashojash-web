<?php

	namespace App\Http\Controllers\BusinessOwner;

	use App\Http\Controllers\Controller;
	use App\Http\Requests;
	use App\Http\Requests\VenueBasicInfoRequest;
	use App\Http\Requests\venueSocialRequest;
	use app\Repository\VenueRepository;
	use App\Venue;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Http\Request;

	class InfoController extends Controller {

		/**
		 * @var VenueRepository
		 */
		private $venueRepository;


		/**
		 * InfoController constructor.
		 * @param VenueRepository $venueRepository
		 */
		public function __construct(VenueRepository $venueRepository)
		{
			$this->venueRepository = $venueRepository;
		}

		public function basic(VenueBasicInfoRequest $request, $venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$this->venueRepository->update($venue, $request->get('name'), $request->get('address'), $request->get('phone'));


			flash()->success(trans("modals.finish"), trans("modals.data_saved"));

			return redirect()->back();

		}

		public function social(VenueSocialRequest $request, $venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$this->venueRepository->update($venue, null, null, null, $request->get('instagram'), $request->get('url'));

			flash()->success(trans("modals.finish"), trans("modals.data_saved"));

			return redirect()->back();


		}

		public function communication(Request $request)
		{
			$this->validate($request, [
				'mobile' => 'regex:/^[0-9]{11}$/'
			]);
			$venue = Venue::findBySlugOrFail($request->route('venueSlug'));
			$venue->mobile = $request->get('mobile');
			$venue->save();
			flash()->success('پایان', 'اطلاعات با موفقیت ذخیره شد');

			return redirect()->back();


		}
	}
