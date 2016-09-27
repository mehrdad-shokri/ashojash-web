<?php namespace App\Api\Transformer;

use App\Photo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use League\Fractal\TransformerAbstract;

class PhotoTransformer extends TransformerAbstract {

	protected $defaultIncludes = ['user'];

	public function transform(Photo $photo)
	{
		$image = Image::make(Storage::disk('local')->get($photo->path));
		return [
			'url' => action("PhotosController@getPhotoByFilename", $photo->filename),
			'width' => $image->width(),
			'height' => $image->height(),
			'createdAt' => $photo->created_at
		];
	}

	public function includeUser(Photo $photo)
	{
		return $this->item($photo->user, new UserTransformer());
	}
}