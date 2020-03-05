<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'id_cate' => 'required',
            'name_phone' => 'required|min:5|max:50|unique:products,name_phone',
            'title' => 'required|min:5|max:190',
            'description' => 'required|min:5|max:190',
            'quantity' => 'required|numeric|digits_between:1,10',
            'detail' => 'required|min:5|max:255',
            'price' => 'required|numeric|digits_between:1,20',
            'size' => 'required',
            'memory' => 'required',
            'weight' => 'required|numeric|digits_between:1,8',
            'cpu_speed' => 'required',
            'ram' => 'required',
            'os' => 'required',
            'camera_primary' => 'required',
            'warranty' => 'required',
            'bluetooth' => 'required',
            'wlan' => 'required',
            'promotion_price' => 'required|numeric|digits_between:1,20',
            'start_promotion' => 'required|date|before_or_equal:end_promotion',
            'end_promotion' => 'required|date|after_or_equal:start_promotion',
            'sale_phone' => 'required',
            'battery' => 'required'
        ];
        if ($this->product) {
            $arr_validate['name_phone'] = 'required|min:5|max:50|unique:products,name_phone,' . $this->product;
        }
        return $arr_validate;
    }

    public function messages()
    {
        return [
            'sale_phone.required' => 'Status of this product is required.',
            'id_cate.required' => 'The category name field is required.'
        ];
    }
}
