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
            // ここでのバリデーションはファイルサイズも入れたほうが良い？(10MBを上限とする)
            // ここで指定した profilePhoto というキーが、ajax通信で返ってくる response の中に入っている
            // response.data.errors で拾える
            'password' => 'bail|required|confirmed|min:8',
            // パスワードフォームと一致していないとエラーを出す
            // 'password_confirmation' => 'required|min:8|same:password',
        ];
    }

    public function messages()
    {
        return [
            "password.required" => '入力必須です',
            "password.confirmed" => '再入力フォームと一致していません。',
            "password.min" => "8文字以上で入力してください"
        ];
    }
}
