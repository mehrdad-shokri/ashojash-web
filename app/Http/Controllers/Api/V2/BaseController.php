<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class BaseController extends Controller {

	protected $citySlugRule = array("citySlug" => "required|exists:cities,slug");

	use Helpers;

	protected function errorResponse($validator)
	{
		return str_replace("\\", "", json_encode($validator->errors(), JSON_UNESCAPED_UNICODE));
	}

	protected function handleValidation($validator)
	{
		if ($validator->fails())
		{
			$this->response->errorBadRequest("Validation failed");
		}
	}
}
