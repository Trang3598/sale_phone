<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'category_name' => 'required|max:50|min:3|unique:categories',
        ];
        if ($this->category) {
            $arr_validate['category_name'] = 'required|max:50|min:3|unique:categories,category_name,' . $this->category;
        }
        return $arr_validate;
    }
}
