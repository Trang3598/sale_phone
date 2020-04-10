<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'customer_name' => 'required|max:50|min:3',
            'customer_phone' => 'required|numeric|digits_between:1,10',
            'customer_email' => 'required|email',
            'delivery_address' =>'required|min:5|max:255',
            'total_price' => 'required|numeric',
            'color_id' => 'required'
        ];
        return $arr_validate;
    }
}
