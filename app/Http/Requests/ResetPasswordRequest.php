<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class ResetPasswordRequest extends FormRequest
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
        return [
            'email'=> 'required|email|exists:users,email',
            'password'=>'required|confirmed|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            //Contain at least one uppercase/lowercase letters and one number
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'password.regex' => Lang::get('validation.custom.custom_password.user'),
        ];
    }
}
