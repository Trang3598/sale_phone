<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,bmp,png|max:2000|unique:images,image',
        ];
        return $arr_validate;
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Please select a product',
            'image.max' => "Maximum file size to upload is 2MB. If you are uploading a photo, try to reduce its resolution to make it under 2MB"
        ];
    }
}
