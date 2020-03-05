<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
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
            'status_name' => 'required|max:50|min:3|unique:status,status_name',
        ];
        if ($this->status) {
            $arr_validate['status_name'] = 'required|max:50|min:3|unique:status,status_name,'. $this->status;
        }
        return $arr_validate;
    }
}
