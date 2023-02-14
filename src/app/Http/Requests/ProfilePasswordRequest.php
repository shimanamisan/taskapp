<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // デフォルトは false なので true にする
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // ここで指定した profilePhoto というキーが、ajax通信で返ってくる response の中に入っている
            // response.data.errors で拾える
            "old_password" => 'bail|required|regex:/^[a-zA-Z0-9]+$/|min:8',
            "password" =>
                'bail|required|regex:/^[a-zA-Z0-9]+$/|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            "password.confirmed" => "再入力フォームと一致していません。",
            "password.min" => "8文字以上で入力してください。",
            "regex" => "半角英数のみご利用いただけます。",
        ];
    }
}
