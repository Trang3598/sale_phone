<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'comment_time' => 'required|date|before:tomorrow',
            'comment_content' => 'required|min:5|string|max:255',
            'phone_number' => 'required|numeric|digits_between:1,10',
        ];
//        if ($this->comment) {
//            $arr_validate['phone_number'] = 'required|numeric|digits_between:1,10|unique:comments,phone_number,' . $this->comment;
//        }
        return $arr_validate;
    }
}
