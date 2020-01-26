<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {   
        // ログイン状態で非ログイン状態でのみアクセスできる機能にリクエストを送信した場合に
        // /home へのリダイレクトが返却されている
        if (Auth::guard($guard)->check()) {

            // ログインユーザー返却 API にリダイレクトするように修正
            return redirect()->route('user'); // 変更
            // return redirect('/home');
        }
        
        // エディタから見たら少し特殊な書き方だがこれで良い
        return $next($request);
    }
}
