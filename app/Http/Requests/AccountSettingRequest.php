<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountSettingRequest extends FormRequest
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
            'avatar' => 'image|max:2000|unique:users,avatar',
            'current_password' => 'required|min:5|alpha_num',
            'password' => 'required|same:confirm|min:5|different:current_password',
            'confirm' => 'required|min:5|same:password|alpha_num',
        ];
        if ($this->user) {
            $arr_validate['username'] = 'required|min:5|max:50|regex:/(^([a-zA-Z]+)(\d+)?$)/u|alpha_dash|string|unique:users,username,' . $this->user;
            $arr_validate['email'] = 'required|email|unique:users,email,' . $this->user;
            $arr_validate['avatar'] = 'image|max:2000|unique:users,avatar,' . $this->user;
        }

        return $arr_validate;
    }
}
