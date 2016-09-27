<?php namespace app\Transformers;


class CityTransformer extends Transformer {

	public function transform($city)
	{
		return [
			'name' => $city['name'],
			'image_url' => action("PhotosController@getCityPhoto", [$city['slug'], 'height' => 600]),
			'slug' => $city['slug']
		];
	}
}