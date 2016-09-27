<?php

	namespace App\Http\Requests;

	use App\Http\Requests\Request;

	class VenueBasicInfoRequest extends Request {

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
				'name'    => 'required|string|min:3',
				'phone'   => 'required|regex:/^[0-9]{10,11}$/|digits_between:10,11',
				'address' => 'required|string'
			];
		}
	}
