<?php namespace app\Transformers;


class VenueTransformer extends Transformer {

	public function transform($venue)
	{

		return [
			'name'      => $venue['name'],
			'slug'      => $venue['slug'],
			'score'     => $venue['score'],
			'cost'      => (int) $venue['cost'],
			'url'       => $venue['url'],
			'instagram' => $venue['instagram'],
			'phone'     => $venue['phone'],
			'mobile'    => $venue['mobile'],
			'address'   => $venue['location']['address'],
			'lat'       => (double) $venue['location']['lat'],
			'lng'       => (double) $venue['location']['lng'],
			'image_url' => action("PhotosController@getVenuePhoto", [$venue['slug']])
		];
	}
}