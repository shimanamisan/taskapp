<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'profilePhoto' => 'required|file|mimes:jpg,jpeg,png,gif|max:10240',
            'email' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => '入力必須です'
        ];
    }
}
