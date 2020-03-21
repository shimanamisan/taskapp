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
            'email' => 'required|email',
            'name' => 'required|max:20',
            'subject' => 'required|max:255',
            'message' => 'required|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '入力必須です。',
            'email.email' => 'メールアドレスを入力してください。',
            'name.required' => '入力必須です。',
            'name.max' => '20文字以内で入力してください。',
            'subject.required' => '入力必須です。',
            'subject.max' => '255文字以内で入力してください。',
            'message.required' => '入力必須です。',
            'message.max' => '1000文字以内で入力してください。',
        ];
    }
}
