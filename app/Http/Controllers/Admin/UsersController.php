<?php namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests;
use app\Repository\PhotoRepository;
use app\Repository\ReviewRepository;
use app\Repository\UserRepository;
use app\Repository\VenueRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UsersController extends Controller {

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
	 * UsersController constructor.
	 * @param UserRepository $userRepository
	 * @param PhotoRepository $photoRepository
	 * @param ReviewRepository $reviewRepository
	 * @param VenueRepository $venueRepository
	 */
	public function __construct(UserRepository $userRepository, PhotoRepository $photoRepository, ReviewRepository $reviewRepository, VenueRepository $venueRepository)
	{
		$this->userRepository = $userRepository;
		$this->photoRepository = $photoRepository;
		Carbon::setLocale('fa');
		$this->reviewRepository = $reviewRepository;
		$this->venueRepository = $venueRepository;
	}

	public function all()
	{
		$users = $this->userRepository->all('roles')->paginate(15);

		return view('admin.users.all', compact('users'));
	}

	public function getSearchEmail(Request $request, $userData)
	{
		if ($request->ajax())
		{
			$array = ['username', 'email', 'name'];
			User::select($array)->where('some queries');
			$users = $this->userRepository->select($array);
			$result = $this->userRepository->like('email', $userData, $users)->get();

			return response()->json($result);
		}
		abort(500);
	}

	public function postSearchEmail(Request $request)
	{
		$user = $this->userRepository->findByPrimaryEmail($request->get('email'));

		return redirect()->action("Owner\UsersController@show", $user->username);
	}

	public function show($username)
	{
		$user = $this->userRepository->findByUsername($username);
		$followers = $user->followers()->get();
		$photos = $this->photoRepository->userUploadedVenuePhotos($user);
		$reviews = $this->reviewRepository->userReviewsSimplePaginated($user);

		return view('admin.users.show', compact('user', 'followers', 'photos', 'reviews'));
	}

	public function toggleBan(Request $request, $userId)
	{
		if ($request->ajax())
		{
			$user = $this->userRepository->findById($userId);
			$user->ban == 0 ? $user->ban = 1 : $user->ban = 0;
			$user->save();

			return response(200);
		}
		abort(500);
	}
}
