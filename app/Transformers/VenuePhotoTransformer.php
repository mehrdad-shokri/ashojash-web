<?php namespace app\Transformers;


class VenuePhotoTransformer extends Transformer {

	public function transform($photo)
	{
		return [
			'image_url' => action("PhotosController@getPhotoByFilename", [$photo['filename']]),
			'username'  => $photo['username']
		];
	}
}