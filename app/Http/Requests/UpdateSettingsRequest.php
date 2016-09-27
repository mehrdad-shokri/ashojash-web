<?php

	namespace App\Http\Requests;

	use App\Http\Requests\Request;

	class UpdateSettingsRequest extends Request {

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
				'name'  => 'required|min:4',
				'bio'   => 'max:140',
				'city'  => 'string',
				'phone' => 'regex:/^[0-9]{10,11}$/|digits_between:10,11',
			];
		}
	}
