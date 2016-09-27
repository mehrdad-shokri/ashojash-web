<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddMenuItemRequest extends Request
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
            'menu_item'   => 'required|string',
            'price'       => 'required|integer|max:4000000|min:100',
            'ingredients' => '	string|max:150',
        ];
    }
}
