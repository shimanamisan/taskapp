<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule; // ★追加
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware("guest");
    }

    /*************************************************************
    SendsPasswordResetEmails トレイトのメソッドをオーバーライド
    **************************************************************/
    public function sendResetLinkEmail(Request $request)
    {
        // emailを検索してきたときに空だった場合に、未登録及び退会済ユーザーは
        // バリデーションに引っかかるようにする
        $this->validator($request->all())->validate();

        $response = $this->broker()->sendResetLink($request->only("email"));

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function validator(array $data)
    {
        // カスタムエラーメッセージ
        $message = [
            "email" => "有効なメールアドレスを指定してください。",
            "email.exists" =>
                "メールアドレスに一致するユーザーは存在していません。",
        ];

        return Validator::make(
            $data,
            [
                "email" => [
                    "required",
                    "string",
                    "email",
                    "max:100",
                    // usersテーブルで退会済みでないユーザーが存在しているか探す（deletef_flgが0のユーザー）
                    Rule::exists("users", "email")->where("delete_flg", 0),
                ],
            ],
            $message
        );
    }

    protected function sendResetLinkResponse($response)
    {
        return response()->json(
            [
                "success" =>
                    "ご登録されているメールアドレスにパスワード再設定用のメールを送信しました。",
            ],
            200
        );
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(
            [
                "errors" => [
                    "email" => ["再設定メールの送信に失敗しました。"],
                ],
            ],
            422
        );
    }

    // メールアドレスのバリデーションチェックのオーバーライド
    public function validateEmail(Request $request)
    {
        $rule = [
            "email" => "bail|required|email|",
        ];

        $messages = [
            "email.required" => "入力必須です。",
        ];

        $this->validate($request, $rule, $messages);
    }

    // 未知のメソッドが満載なので調べたい。
    // protected function sendResetLinkFailedResponse(Request $request, $response)
    // {
    //     return back()
    //             ->withInput($request->only('email'))
    //             ->withErrors(['email' => trans($response)]);
    // }
}
