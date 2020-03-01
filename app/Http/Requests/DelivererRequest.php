<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DelivererRequest extends FormRequest
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
            'deliverer_name' => 'required|max:50|min:3|unique:deliverer',
            'deliverer_phone' => 'required|numeric|unique:deliverer|digits_between:1,10',
            'created_at' => 'required|date|before_or_equal:updated_at|before:tomorrow',
            'updated_at' => 'required|date|after_or_equal:created_at|before:tomorrow'
        ];
        if ($this->deliverer) {
            $arr_validate['deliverer_name'] = 'required|max:50|min:3|unique:deliverer,deliverer_name,' . $this->deliverer;
            $arr_validate['deliverer_phone'] = 'required|numeric|digits_between:1,10|unique:deliverer,deliverer_phone,' . $this->deliverer;
        }
        return $arr_validate;
    }
}
