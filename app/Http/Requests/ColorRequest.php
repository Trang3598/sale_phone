<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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
        $arr_validate = [
            'product_id' => 'required',
            'color_name' => 'required',
            'created_at' => 'required|date|before_or_equal:updated_at|before:tomorrow',
            'updated_at' => 'required|date|after_or_equal:created_at|before:tomorrow'
        ];
        return $arr_validate;
    }
}
