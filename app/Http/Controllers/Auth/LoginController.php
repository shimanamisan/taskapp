<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserDelete;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // ★ 追加
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

    // authenticatedメソッドをコントローラー側でオーバーライドして使う。継承元のクラスでは authenticatedメソッドは空になっている
    protected function authenticated(Request $request, $user)
    {
        return $user;
    }

    // メソッド追加
    protected function loggedOut(Request $request)
    {
    // セッションを再生成する（接続を一旦リセットしている？）
    $request->session()->regenerate();

    return response()->json();
    }
}
