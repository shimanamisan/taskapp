<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str; // 追加
use Illuminate\Http\Request;
// use Illuminate\Contracts\Auth\CanResetPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash; // 追加
use Illuminate\Support\Facades\Password; // 追加
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\ResetPasswordRequest; // 追加

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = "/home";

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
    ResetsPasswords.php トレイトのメソッドをオーバーライド
    **************************************************************/

    public function reset(ResetPasswordRequest $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        // ここでは、ユーザーのパスワードをリセットします。
        // それが成功すれば、私たちはは実際のユーザーモデルのパスワードを更新し、
        // データベース。それ以外の場合は、エラーを解析して応答を返します。
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // パスワードが正常にリセットされた場合は、アプリケーションのホーム認証ビューへリダイレクトします。
        // もし間違いがあれば、エラーメッセージが表示された元の場所にリダイレクトします。
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }
    protected function rules()
    {
        return [
            "token" => "required",
            "email" => "required|email|max:100",
            "password" => 'required|confirmed|min:8|regex:/^[a-zA-Z0-9]+$/',
        ];
    }

    public function broker()
    {
        return Password::broker();
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return response()->json(
            [
                "message" => "パスワードをリセットしました。",
                "response" => $response,
            ],
            200
        );
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response()->json(
            [
                "message" => "パスワードのリセットに失敗しました。",
                "response" => $response,
            ],
            500
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        // event(new PasswordReset($user));

        // $this->guard()->login($user);
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            "email",
            "password",
            "password_confirmation",
            "token"
        );
    }
}
