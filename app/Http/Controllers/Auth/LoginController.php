<?php

namespace App\Http\Controllers\Auth;

use App\User; // 追加
use Socialite; // 追加
use App\Models\UserDelete;
use App\Http\Requests\LoginRequest; // 追加
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

    // twitterログイン
    /**
     * OAuth認証先にリダイレクト
     *
     * @param str $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {   
        // return Socialite::driver()->response(['provider'], $provider);
        return Socialite::driver($provider)->redirect();
    }

    /**
     * OAuth認証の結果受け取り
     *
     * @param str $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $providerUser = Socialite::with($provider)->user();
        } catch(\Exception $e) {
            return redirect('/login')->with('oauth_error', '予期せぬエラーが発生しました');
        }

        if ($email = $providerUser->getEmail()) {
            Auth::login(User::firstOrCreate([
                'email' => $email
            ], [
                'name' => $providerUser->getName()
            ]));

            return redirect($this->redirectTo);
        } else {
            return redirect('/login')->with('oauth_error', 'メールアドレスが取得できませんでした');
        }
    }
}
