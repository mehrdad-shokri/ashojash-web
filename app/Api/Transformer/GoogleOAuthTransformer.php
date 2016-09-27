<?php namespace App\Api\Transformer;


use League\Fractal\TransformerAbstract;

class GoogleOAuthTransformer extends TransformerAbstract {

	public function transform()
	{
		return [
			'isNewUser' => session()->has('api_flash_message') ? true : false
		];
	}
}