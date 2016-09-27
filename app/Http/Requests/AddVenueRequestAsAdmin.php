<?php

namespace App\Http\Requests;

class AddVenueRequestAsAdmin extends Request {

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
			'lat' => 'required|numeric',
			'lng' => 'required|numeric',
			'city' => 'integer',
		];
	}
}
