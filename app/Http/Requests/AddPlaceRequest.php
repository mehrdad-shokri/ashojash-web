<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddPlaceRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required|min:5|string',
			'address' => 'required|min:10|string',
			'phone' => 'regex:/^[0-9]{10,11}$/|digits_between:10,11',
			'v-lat' => 'numeric',
			'v-lng' => 'numeric',
			'city' => 'integer',
		];
	}
}
