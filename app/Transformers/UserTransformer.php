<?php namespace app\Transformers;


class UserTransformer extends Transformer {

	public function transform($user)
	{
		return [
			'name'      => $user['name'],
			'username'  => $user['username'],
			'email'     => $user['email'],
			'image_url' => action("PhotosController@getUserAvatar", [$user['username']])
		];
	}
}