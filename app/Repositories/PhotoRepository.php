<?php namespace app\Repository;

use App\City;
use App\Collection;
use App\Cuisine;
use App\Tag;
use App\User;
use App\Venue;

interface PhotoRepository {

	public function userUploadedVenuePhotos(User $user);

	public function cityPhoto(City $city);

	public function venueMainPhoto(Venue $venue);

	public function venuePhotos(Venue $venue);

	public function venuePhotosCount(Venue $venue);

	public function userAvatar(User $user);

	public function filename($filename);

	public function cuisinePhoto(Cuisine $cuisine);

	public function collectionPhoto(Collection $collection);

	public function tagPhoto(Tag $tag);

	public function venuePhotosPaginated(Venue $venue, $limit = 8);
}