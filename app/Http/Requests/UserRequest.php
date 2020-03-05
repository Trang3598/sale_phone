<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'avatar' => 'image|max:2000|unique:users,avatar',
            'current_password' => 'required|min:5',
            'new_password' => 'required|same:confirm_new_pw|min:5|different:current_password',
            'confirm_new_pw' => 'required|min:5|same:new_password|alpha_num',
        ];
        if ($this->user) {
            $arr_validate['username'] = 'required|min:5|max:50|regex:/(^([a-zA-Z]+)(\d+)?$)/u|alpha_dash|string|unique:users,username,' . $this->user;
            $arr_validate['email'] = 'required|email|unique:users,email,' . $this->user;
            $arr_validate['avatar'] = 'image|max:2000|unique:users,avatar,' . $this->user;
        }

        return $arr_validate;
    }

    public function messages()
    {
        return [
            'confirm_new_pw.required' => 'The confirm new password field is required.',
        ];
    }
}
