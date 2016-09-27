<?php

	namespace App\Http\Requests;


	class ScheduleRequest extends Request {

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
			$rules = [];
			if (!is_null($this->request->get('clockPickerFrom')))
				foreach ($this->request->get('clockPickerFrom') as $key => $val)
				{
					$rules['clockPickerFrom.' . $key] = 'required|date_format:H:i';
					$rules['clockPickerTo.' . $key] = 'required|date_format:H:i';
				}

			return $rules;
		}

		public function messages()
		{
			$messages = [];
			if (!is_null($this->request->get('clockPickerFrom')))
				foreach ($this->request->get('clockPickerFrom') as $key => $val)
				{
//                $messages['clockPickerFrom.' . $key . '.max'] = 'The field labeled "Book Title ' . $key . '" must be less than :max characters.';
					$messages['clockPickerFrom.' . $key . '.required'] = "ساعت شروع کسب و کارتان در سطر " . ($key + 1) . " الزامی است";
					$messages['clockPickerTo.' . $key . '.required'] = "ساعت پایان کسب و کارتان در سطر " . ($key + 1) . " الزامی است";
//                $messages['clockPickerTo.' . $key . '.size'] = "تعداد کاراکترهای ساعت شروع کسب و کارتان در سطر " . ($key + 1) . " ، باید :size کاراکتر باشد";
//                $messages['clockPickerFrom.' . $key . '.size'] = "تعداد کاراکترهای ساعت پایان کسب و کارتان در سطر " . ($key + 1) . " ، باید :size کاراکتر باشد";
					$messages['clockPickerFrom.' . $key . '.date_format'] = " ساعت شروع کسب و کارتان در سطر" . ($key + 1) . "  یک زمان معتبر نیست ";
					$messages['clockPickerTo.' . $key . '.date_format'] = " ساعت پایان کسب و کارتان در سطر" . ($key + 1) . " یک زمان معتبر نیست  ";
				}

			return $messages;
		}
	}
