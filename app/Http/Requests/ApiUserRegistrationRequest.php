<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ApiUserRegistrationRequest extends Request
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
            'name'     => 'required|max:255',
            'username' => 'required|max:255|unique:users|min:4|regex:/^[a-zA-Z0-9-]*$/',
            'email'    => 'required|email|max:255|unique:users|unique:google_oauth',
            'password' => 'required|min:6',
        ];
    }
}
