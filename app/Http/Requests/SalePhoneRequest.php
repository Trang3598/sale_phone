<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalePhoneRequest extends FormRequest
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
            'phone_id' => 'required|unique:sale_phones,phone_id,',
            'quantity' => 'required|numeric|digits_between:1,10',
        ];
        return $arr_validate;
    }
    public function messages()
    {
        return [
            'phone_id.unique' => 'This phone name has already been choosen.',
        ];
    }
}
