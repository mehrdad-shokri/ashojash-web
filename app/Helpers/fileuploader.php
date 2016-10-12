<?php

use App\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    public static function uploadFile(Model $model, UploadedFile $file, $user, $isUnique = false)
    {
        $clientFileName = $file->getClientOriginalName();
        $nameToBeSaved = time() . str_slug($clientFileName);
        $mimeType = $file->getMimeType();
        $image = file_get_contents($file->getRealPath());
        $model->touch();
        $morphClass = $model->getMorphClass();
        if ($morphClass === "App\City") {
            self::createOrUpdateCityPhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $user->getKey());
        } else if ($morphClass === "App\Venue") {
            if ($isUnique)
                self::createOrUpdateVenueMainPhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $user->getKey());
            else
                self::createVenuePhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $user->getKey());
        } else if ($morphClass === "App\User") {
            self::createOrUpdateUserProfilePhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $user->getKey());
        } else if ($morphClass === "App\Cuisine") {
            self::createOrUpdateCuisinePhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $user->getKey());
        } else if ($morphClass == "App\Collection") {
            self::createOrUpdateCollectionPhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $user->getKey());
        }
        else if ($morphClass == "App\Tag")
		{
			self::createOrUpdateTagPhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $user->getKey());
		}
    }

    private static function createOrUpdateCityPhoto(Model $model, $clientFileName, $nameToBeSaved, $mimeType, $image, $userId)
    {
        $path = "city/" . "$model->slug/" . $nameToBeSaved;
        $cityId = $model->getKey();
        $morphClass = $model->getMorphClass();
        if ($model->photo()->first())
            Storage::disk('local')->delete($model->photo()->first()->path);
        $model->photo()->updateOrCreate(array('imageable_type' => $morphClass, 'imageable_id' => $cityId), array('path' => $path, 'filename' => $nameToBeSaved, 'original_filename' => $clientFileName, 'mime' => $mimeType, 'user_id' => $userId));
        Storage::disk('local')->put($path, $image);

    }

    private static function createOrUpdateVenueMainPhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $userId)
    {
        $path = 'venue/' . "$model->slug/" . $nameToBeSaved;
        $venueId = $model->getKey();
        $morphClass = $model->getMorphClass();
        //photo is not been assigned Or photo is being deleted
        if (!($model->hasImgId())) {
            $photo = $model->photos()->create(array('path' => $path, 'filename' => $nameToBeSaved, 'original_filename' => $clientFileName, 'mime' => $mimeType, 'user_id' => $userId));
            Storage::disk('local')->put($path, $image);
            $model->setImgId($photo->getKey());
        } else {
            Storage::disk('local')->delete($model->photos()->where('id', $model->getImgId())->first()->path);
            $model->photos()->updateOrCreate(array('imageable_type' => $morphClass, 'imageable_id' => $venueId, 'id' => $model->getImgId()), array('path' => $path, 'filename' => $nameToBeSaved, 'original_filename' => $clientFileName, 'mime' => $mimeType));
            Storage::disk('local')->put($path, $image);
        }
    }

    private static function createOrUpdateUserProfilePhoto($user, $clientFileName, $nameToBeSaved, $mimeType, $image, $userId)
    {
        $path = 'user/' . "$user->username/" . $nameToBeSaved;
        $userId = $user->getKey();
        $morphClass = $user->getMorphClass();
        //photo has not been assigned Or photo is being deleted

//        If photos has a record with imageable_type => App\User && imageable_id Auth::user()
        if ($user->hasProfileImg()) {
            Storage::disk('local')->delete($user->photo()->where('imageable_id', $user->getKey())->where('imageable_type', $user->getMorphClass())->first()->path);
            $user->photo()->updateOrCreate(array('imageable_type' => $morphClass, 'imageable_id' => $userId), array('path' => $path, 'filename' => $nameToBeSaved, 'original_filename' => $clientFileName, 'mime' => $mimeType));
            Storage::disk('local')->put($path, $image);
            $user->touch();
            $user->save();
        } else {
            $user->photo()->create(array('path' => $path, 'filename' => $nameToBeSaved, 'original_filename' => $clientFileName, 'mime' => $mimeType));
            Storage::disk('local')->put($path, $image);
            $user->touch();
            $user->save();
        }
    }

    private static function createVenuePhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $userId)
    {
        $path = 'venue/' . "$model->slug/" . $nameToBeSaved;
        $model->photos()->create(array('path' => $path, 'filename' => $nameToBeSaved, 'original_filename' => $clientFileName, 'mime' => $mimeType, 'user_id' => $userId));
        Storage::disk('local')->put($path, $image);
    }

    private static function createOrUpdateCuisinePhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $userId)
    {
        $path = "cuisine/" . "$model->slug/" . $nameToBeSaved;
        $cuisinePhoto = $model->getKey();
        $morphClass = $model->getMorphClass();
        if ($model->photo()->first())
            Storage::disk('local')->delete($model->photo()->first()->path);
        $model->photo()->updateOrCreate(array('imageable_type' => $morphClass, 'imageable_id' => $cuisinePhoto), array('path' => $path, 'filename' => $nameToBeSaved, 'original_filename' => $clientFileName, 'mime' => $mimeType, 'user_id' => $userId));
        Storage::disk('local')->put($path, $image);
    }

    private static function createOrUpdateCollectionPhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $userId)
    {
        $path = "collections/" . $nameToBeSaved;
        $collectionId = $model->getKey();
        $morphClass = $model->getMorphClass();
        if ($model->photo()->first())
            Storage::disk('local')->delete($model->photo()->first()->path);
        $model->photo()->updateOrCreate(array('imageable_type' => $morphClass, 'imageable_id' => $collectionId), array('path' => $path, 'filename' => $nameToBeSaved, 'original_filename' => $clientFileName, 'mime' => $mimeType, 'user_id' => $userId));
        Storage::disk('local')->put($path, $image);
    }
    private static function createOrUpdateTagPhoto($model, $clientFileName, $nameToBeSaved, $mimeType, $image, $userId)
    {
        $path = "tags/" . $nameToBeSaved;
        $tagId = $model->getKey();
        $morphClass = $model->getMorphClass();
        if ($model->photo()->first())
            Storage::disk('local')->delete($model->photo()->first()->path);
        $model->photo()->updateOrCreate(array('imageable_type' => $morphClass, 'imageable_id' => $tagId), array('path' => $path, 'filename' => $nameToBeSaved, 'original_filename' => $clientFileName, 'mime' => $mimeType, 'user_id' => $userId));
        Storage::disk('local')->put($path, $image);
    }
}