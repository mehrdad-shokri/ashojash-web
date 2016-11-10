<?php namespace App\Api\Transformer;

use App\Venue;
use League\Fractal\Manager;

class VenueTransformer extends BaseTransformer {


	protected $availableIncludes = [
		'reviews', 'photos', 'menus'
	];
	protected $defaultIncludes = [
		'mainPhoto', 'location'
	];

	/**
	 * VenueTransformer constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		if (isset($_GET['include']))
		{
			$manager = new Manager();
			$manager->parseIncludes($_GET['include']);
		}
	}

	public function transform(Venue $venue)
	{
		$response = ['name' => $venue->name,
			'slug' => $venue->slug,
			'score' => $venue->score,
			'cost' => $venue->cost,
			'phone' => $venue->phone,
			'reviewsCount' => $this->venueRepository->venueReviewsCount($venue),
			'menusCount' => $this->venueRepository->venueMenusCount($venue),
			'photosCount' => $this->venueRepository->venuePhotosCount($venue)];
		if ($venue->distance)
			$response['distance'] = $venue->distance;
		return $response;
	}

	public function includeMainPhoto(Venue $venue)
	{
		$photo = $this->photoRepository->venueMainPhoto($venue);
		return $this->item($photo, new SimplePhotoTransformer());
	}

	public function includeLocation(Venue $venue)
	{
		$location = $venue->location;
		return $this->item($location, new LocationTransformer());
	}

	public function includeMenus(Venue $venue)
	{
		return $this->collection($this->menuRepository->menus($venue)->take(4), new MenuTransformer());
	}

	public function includeReviews(Venue $venue)
	{
		return $this->collection($this->reviewRepository->venueReviews($venue)->take(3)->get(), new ReviewTransformer());
	}

	public function includePhotos(Venue $venue)
	{
		return $this->collection($this->photoRepository->venuePhotos($venue)->take(3), new PhotoTransformer());
	}
}