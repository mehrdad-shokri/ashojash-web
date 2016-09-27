<?php

	namespace App\Http\Controllers\BusinessOwner;

	use App\Http\Controllers\Controller;
	use App\Http\Requests;
	use App\Http\Requests\AddMenuItemRequest;
	use App\Menu;
	use app\Repository\MenuRepository;
	use app\Repository\VenueRepository;
	use App\Venue;
	use Illuminate\Database\Eloquent\ModelNotFoundException;
	use Illuminate\Http\Request;

	class MenusController extends Controller {

		/**
		 * @var VenueRepository
		 */
		private $venueRepository;
		/**
		 * @var MenuRepository
		 */
		private $menuRepository;


		/**
		 * MenusController constructor.
		 * @param VenueRepository $venueRepository
		 * @param MenuRepository $menuRepository
		 */
		public function __construct(VenueRepository $venueRepository, MenuRepository $menuRepository)
		{
			$this->venueRepository = $venueRepository;
			$this->menuRepository = $menuRepository;
		}

		public function create($venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);

			return view('biz-owner.menus.create', compact('venue'));

		}

		public function edit($venueSlug, $menuId)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$menu = $this->menuRepository->findById($venue, $menuId);

			return view('biz-owner.menus.edit', compact('venue', 'menu'));

		}

		public function update(AddMenuItemRequest $request, $venueSlug, $menuId)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$menu = $this->menuRepository->findById($venue, $menuId);
			$menu->menu_item = $request->menu_item;
			$menu->ingredients = $request->ingredients;
			$menu->price = $request->price;
			$menu->save();
			flash()->success(trans("modals.finish"), trans("modals.data_saved"));

			return redirect()->action("BusinessOwner\MenusController@edit", array($venueSlug, $menuId));

		}

		public function all($venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$menus = $this->menuRepository->menus($venue);

			return view('biz-owner.menus.all', compact('venue', 'menus'));
		}

		public function store(AddMenuItemRequest $request, $venueSlug)
		{
			$venue = $this->venueRepository->findBySlugOrFail($venueSlug);
			$this->menuRepository->create($venue,$request->get('menu_item'), $request->get('price'), $request->get('ingredients'));
			flash()->success(trans('modals.finish'), trans('modals.item_added'));

			return redirect()->action('BusinessOwner\MenusController@create', $venue->slug);
		}
	}
