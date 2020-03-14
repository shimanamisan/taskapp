<?php

namespace App\Http\Controllers\Auth;

use App\User; // 追加
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // ★ 追加
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // リクエストコントローラーを適応するため、トレイトのメソッドをオーバーライド
    // トレイト側でコントローラーを指定しても同じ動きだが、オーバーライドしたほうが
    // 何かバリデーションの変更があった際に対応しやすいと考えた。
    public function login(LoginRequest $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    // authenticatedメソッドをコントローラー側でオーバーライドして使う。継承元のクラスでは authenticatedメソッドは空になっている
    protected function authenticated(Request $request, $user)
    {   
        // ここで渡ってくる$userは、Auth::guard()で認証されたユーザーが渡ってくる
        // 論理削除済みのユーザーか判断するには、AuthenticatesUsersトレイト側で行う
        return $user;
    }

    // メソッド追加
    protected function loggedOut(Request $request)
    {
    // セッションを再生成する（接続を一旦リセットしている？）
    $request->session()->regenerate();
    // csrfトークンも一旦リセット
    $request->session()->regenerateToken();

    return response()->json();
    }
}
