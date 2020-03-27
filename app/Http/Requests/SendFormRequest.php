<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendFormRequest extends FormRequest
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

    public function rules()
    {
        $arr_validate = [
            'username' => 'required|min:5|max:50|unique:users,username|regex:/(^([a-zA-Z]+)(\d+)?$)/u|alpha_dash|string',
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required|min:5',
            'password' => 'required|same:confirm|min:5',
            'confirm' => 'required|min:5|same:password|alpha_num',
            'phone_number' => 'required|numeric|unique:users|digits_between:1,10',
        ];
        return $arr_validate;
    }
}
