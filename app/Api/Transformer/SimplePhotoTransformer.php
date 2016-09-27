<?php namespace App\Api\Transformer;

use App\Photo;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use League\Fractal\TransformerAbstract;

class SimplePhotoTransformer extends TransformerAbstract {


//cuisine, venue
	public function transform(Photo $photo)
	{
		$image = Image::make(Storage::disk('local')->get($photo->path));
		return [
			'url' => action("PhotosController@getPhotoByFilename", $photo->filename),
			'width' => $image->width(),
			'height' => $image->height()
		];
	}
}