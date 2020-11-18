<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // デフォルトはfalseなのでtrueにする
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
            "title" => "bail|required|max:20",
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "入力必須です",
            "title.max" => "20文字以内で入力してください",
        ];
    }
}
