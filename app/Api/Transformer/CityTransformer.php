<?php namespace App\Api\Transformer;

use App\City;

class CityTransformer extends BaseTransformer {


	protected $defaultIncludes = [
		'photo'
	];

	/**
	 * CityTransformer constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function transform(City $city)
	{
		return [
			'name' => $city->name,
			'slug' => $city->slug,
		];
	}

	public function includePhoto(City $city)
	{
		$photo = $this->photoRepository->cityPhoto($city);
		return $this->item($photo, new SimplePhotoTransformer());
	}
}