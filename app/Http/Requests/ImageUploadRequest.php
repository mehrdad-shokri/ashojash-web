<?php

    namespace App\Http\Requests;

    use App\Http\Requests\Request;
    use Illuminate\Support\Facades\Auth;

    class ImageUploadRequest extends Request
    {
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
                'file'=>'required|MAX:5000|mimes:jpg,jpeg,png'
            ];
        }
    }
