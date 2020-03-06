<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            "email" => 'required|email',
            "token" => 'required',
            "password" => 'required|confirmed|min:8'
        ];
    }

    public function messages()
    {
        return [
            "email.required" => '入力必須です',
            "token.required" => '入力必須です',
            "password.required" => '入力必須です',
            "password.confirmed" => '再入力フォームと一致していません。',
            "password.min" => "8文字以上で入力してください"
        ];
    }
}
