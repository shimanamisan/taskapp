<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => "bail|required|max:20|unique:users",
            "email" => "bail|required|email",
            "password" => "bail|required|confirmed|min:8",
        ];
    }

    public function messages()
    {
        return [
            "name.max" => "20文字以内で入力してください。",
            "name.unique" => "既に使用されているユーザー名です。",
            "email.email" => "メールアドレスを入力してください。",
            "password.confirmed" => "再入力フォームと一致していません。",
            "password.min" => "8文字以上で入力してください。",
        ];
    }
}
