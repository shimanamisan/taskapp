<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            "email" => "required|email",
            "name" => "required|max:20",
            "subject" => "required|max:255",
            "message" => "required|max:1000",
        ];
    }

    public function messages()
    {
        return [
            "email.email" => "メールアドレスを入力してください。",
            "name.max" => "20文字以内で入力してください。",
            "subject.max" => "255文字以内で入力してください。",
            "message.max" => "1000文字以内で入力してください。",
        ];
    }
}
