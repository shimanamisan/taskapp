<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileEmailRequest  extends FormRequest
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

            // bailで最初のバリデーションに引っかかったら残りのバリデーションは行わない
            // email:rfc,dnsでRFCValidationとDNSCheckValidationバリデーションを適用している。
            // フィールドがメールアドレスとして正しいか見ている
            'email' => 'bail|required|email',
        ];
    }

    
    // リクエストコントローラーでバリデーションメッセージを上書きできる
    public function messages()
    {
        return [
            'email.required' => '入力必須です',
            'email.email' => 'メールアドレスを入力してください',
        ];
    }
}
