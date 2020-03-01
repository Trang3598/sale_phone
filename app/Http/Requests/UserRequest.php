<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => 'required|min:5|max:50|unique:users,username|regex:/(^([a-zA-Z]+)(\d+)?$)/u|alpha_dash|string',
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required|min:5',
            'password' => 'required|min:5|required_with:confirm|same:confirm|alpha_num',
            'confirm' => 'required|min:5|same:password|alpha_num',
            'created_at' => 'required|date|before_or_equal:updated_at|before:tomorrow',
            'updated_at' => 'required|date|after_or_equal:created_at|before:tomorrow'
        ];
        if ($this->user) {
            $arr_validate['username'] = 'required|min:5|max:50|regex:/(^([a-zA-Z]+)(\d+)?$)/u|alpha_dash|string|unique:users,username,' . $this->user;
            $arr_validate['email'] = 'required|email|unique:users,email,' . $this->user;
        }

        return $arr_validate;
    }
}
