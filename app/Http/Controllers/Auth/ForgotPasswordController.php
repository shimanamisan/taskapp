<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;



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
        $this->middleware('guest');
    }

    /*************************************************************
    SendsPasswordResetEmails トレイトのメソッドをオーバーライド
    **************************************************************/
    public function sendResetLinkEmail(Request $request)
    {   

        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);

    }

    protected function sendResetLinkResponse($response)
    {
        return response()->json(['success' => 'ご登録されているメールアドレスにパスワード再設定用のメールを送信しました。'],200);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['error' => '再設定メールの送信に失敗しました。'], 500);
    }

    
    // メールアドレスのバリデーションチェックのオーバーライド
    public function validateEmail(Request $request)
    {
        $rule = [
            'email' => 'required|email'
        ];

        $messages = [
            'email.required' => '入力必須です'
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
