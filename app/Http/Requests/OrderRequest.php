<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'customer_name' => 'required|max:50|min:3|unique:orders,customer_name',
            'customer_phone' => 'required|numeric|digits_between:1,10|unique:orders,customer_phone',
            'customer_email' => 'required|email|unique:orders,customer_email',
            'status_id' => 'required',
            'deliverer_id' => 'required',
            'total_price' => 'required|numeric',
            'delivery_address' =>'required|min:5|max:255',
        ];
        if ($this->order) {
            $arr_validate['customer_name'] = 'required|max:50|min:3|unique:orders,customer_name,' . $this->order;
            $arr_validate['customer_phone'] = 'required|numeric|digits_between:1,10|unique:orders,customer_phone,' . $this->order;
            $arr_validate['customer_email'] = 'required|email|unique:orders,customer_email,' . $this->order;
        }
        return $arr_validate;
    }
}
