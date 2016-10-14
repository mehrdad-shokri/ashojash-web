<?php
namespace app\Repository;


use App\City;
use App\Collection;
use App\Cuisine;
use App\Photo;
use App\Tag;
use App\User;
use App\Venue;

class DbPhotoRepository implements PhotoRepository {

	public function userUploadedVenuePhotos(User $user)
	{
		return Photo::where('user_id', $user->getKey())->where("imageable_type", "App\Venue")->get();
//        Getting results based on inner join
		/* return User::join('photos','photos.user_id','=','users.id')
			 ->where('users.id',$this->getKey())
			 ->select('photos.*');*/
	}

	public function cityPhoto(City $city)
	{
		$cityPhoto = $city->photo->first();
		return $cityPhoto ? $cityPhoto : self::getDefaultPhoto();
	}

	public function venueMainPhoto(Venue $venue)
	{
		$venueMainPhoto = $venue->photos()->where('id', $venue->image_id)->first();
		return $venueMainPhoto ? $venueMainPhoto : self::getDefaultPhoto();
	}

	public function userAvatar(User $user)
	{
		$userPhoto = Photo::where('imageable_type', "App\User")->where('imageable_id', $user->getKey())->first();
		return $userPhoto ? $userPhoto : self::getUserDefaultAvatar();
	}

	public function filename($filename)
	{
		return Photo::where("filename", $filename)->firstOrFail();
	}

	public function cuisinePhoto(Cuisine $cuisine)
	{
		$cuisinePhoto = $cuisine->photo()->first();
		return $cuisinePhoto ? $cuisinePhoto : self::getDefaultPhoto();
	}

	public function collectionPhoto(Collection $collection)
	{
		$collectionPhoto = $collection->photo()->first();
		return $collectionPhoto ? $collectionPhoto : self::getDefaultPhoto();
	}

	public function tagPhoto(Tag $tag)
	{
		$tagPhoto = $tag->photo()->first();
		return $tagPhoto;
	}

	public function venuePhotos(Venue $venue)
	{
		return $venue->photos()->latest()->get();
	}

	public function venuePhotosCount(Venue $venue)
	{
		return $this->venuePhotos($venue)->count();
	}

	public function venuePhotosPaginated(Venue $venue, $limit = 8)
	{
		return $venue->photos()->latest()->Paginate($limit);
	}

	private function getDefaultPhoto()
	{
		$photo = Photo::where("filename", 'blur.jpg')->firstOrFail();
		return $photo;
	}

	private function getUserDefaultAvatar()
	{
		$photo = Photo::where("filename", 'favatar.jpg')->firstOrFail();
		return $photo;
	}
}